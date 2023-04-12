<?php

namespace App\Http\Controllers;

use App\AnnualReport;
use App\Category;
use App\Certificate;
use App\Contact;
use App\Emagazine;
use App\FinancialReport;
use App\Gallery;
use App\Management;
use App\Menu;
use App\Menus;
use App\MenuShortcut;
use App\News;
use App\Page;
use App\Product;
use App\ProgramEmpowerment;
use App\ProgramTjsl;
use App\Slider;
use App\SliderBottom;
use App\SustainabilityReport;
use App\Timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use stdClass;

class WebController extends Controller
{
  public function eBook(Request $request, $book)
  {
    $ebook_dir = base64_decode($request->v);
    $book = url('public') . $ebook_dir . $book;
    return view('web.ebook', compact('book'));
  }
  public function downloadFile(Request $request, $file)
  {
    $file_dir = base64_decode($request->v);
    $file_path = public_path() . $file_dir . $file;
    $headers = array('Content-Type: application/pdf');
    return response()->download($file_path, $file, $headers);
  }

  public function index(Request $request, $locale, $pages)
  {
    $nav = generateMenu($locale, 'main');
    $nav_right = generateMenu($locale, 'right');
    $nav_shortcut = MenuShortcut::where('lang', '=', $locale)->get();
    $menu = Menu::where('lang', '=', $locale)->where('alias', '=', $pages)->firstOrFail();
    $menu_id = $menu->id;
    $nav_lang = Menu::where('ref', '=', $menu->ref)->get()->toArray();
    if (!$menu_id) {
      return abort(404, 'page not found.');
    }
    $find_menu = getActiveMenu($menu->menu_position == 'main' ? $nav : $nav_right, $menu_id);
    $active_menu = $find_menu[0];
    $next_menu = $find_menu[1];
    if ($next_menu == null && $menu->menu_position == 'main') {
      $next_menu = $nav_right[0]->child[0];
    } elseif ($next_menu == null && $menu->menu_position == 'right') {
      $next_menu = $nav[0];
    }

    // dd($next_menu);
    $menu_ids = [];
    if (isset($active_menu->child) && $active_menu->child) {
      foreach ($active_menu->child as $value) {
        $menu_ids[] = $value->id;
      }
    } else {
      $menu_ids[] = $active_menu->id;
    }
    $slider = [];
    $slider_bottom = [];
    if ($active_menu->ref == 1) {
      $slider = Slider::where('lang', '=', $locale)->orderBy('reorder')->get();
      $slider_bottom = SliderBottom::where('lang', '=', $locale)->orderBy('reorder')->get();
    }

    $pages = Page::whereIn('id_menu', $menu_ids)->orderBy('reorder')->get();
    if (!count($pages)) {
      return view('web.coming-soon', compact('pages', 'locale', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu', 'next_menu'));
    }
    return view('web.pages', compact('pages', 'locale', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu', 'slider', 'slider_bottom', 'next_menu'));
  }

  public function pageDetail($locale, $pages, $url)
  {
    $nav = generateMenu($locale, 'main');
    $nav_right = generateMenu($locale, 'right');
    $nav_shortcut = MenuShortcut::where('lang', '=', $locale)->get();
    $menu = Menus::where('lang', '=', $locale)->where('alias', '=', $pages)->first();
    $menu_id = $menu->id;
    $active_menu = $menu;
    $views = 'web.page-detail';
    $slider = [];
    $slider_bottom = [];
    $nav_lang = [];
    if ($active_menu->alias == 'news-detail') {
      $active_menu->title = $menu->title;
      $views = 'web.news-detail';
      $news = News::where('url', $url)->get();
      foreach ($news as $navlang) {
        $nav_lang[] = ["lang" => $navlang->lang, "alias" => $active_menu->alias . "/" . $navlang->url];
        if ($navlang->lang == $locale) {
          $detail = $navlang;
          $active_menu->title = Category::where('id', $navlang->id_category)->first()->title;
        }
      };
    }
    return view($views, compact('detail', 'locale', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu', 'slider', 'slider_bottom'));
  }
  public function findHref($menus, $id) {
    foreach ($menus as $lvl1) {
        if (isset($lvl1->child) && count($lvl1->child) > 0) {
            foreach ($lvl1->child as $lvl2) {
                if (isset($lvl2->child) && count($lvl2->child) > 0) {
                    foreach ($lvl2->child as $lvl3) {
                        if (isset($lvl3->child) && count($lvl3->child) > 0) {
                            foreach ($lvl3->child as $lvl4) {
                                if ($lvl4->id == $id) {
                                    return $lvl4;
                                }
                            }
                        }
                        if ($lvl3->id == $id) {
                            return $lvl3;
                        }
                    }
                }
                if ($lvl2->id == $id) {
                    return $lvl2;
                }
            }
        }
        if ($lvl1->id == $id) {
            return $lvl1;
        }
    }
    return null;
  }

  public function highlightWords($text, $word){
    $text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
    return $text;
  }
  public function limit_text($text, $limit, $keyword) {
    if (str_word_count($text, 0) > $limit) {
      $words = str_word_count($text, 2);
      $pos   = array_keys($words);
      $resttext  = substr($text, $pos[$limit]);
      $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    if (!preg_match('/'.$keyword.'/i', $text) && isset($resttext)){
        if (str_word_count($resttext, 0) > $limit) {
            $text = $this->limit_text($resttext, $limit, $keyword);
        }else{
            $text = $resttext;
        }
    }
    return $this->highlightWords($text, $keyword);
  }
  public function search(Request $request, $locale)
  {
    if(count($request->query()) === 0) {
        return redirect()->route('web.index', [$locale, 'home']);
    }
    $nav = generateMenu($locale, 'main');
    $nav_right = generateMenu($locale, 'right');
    $nav_shortcut = MenuShortcut::where('lang', '=', $locale)->get();
    $active_menu = new stdClass();
    $active_menu->id = '';
    $active_menu->banner_img = '';
    $active_menu->title = trans('web.searching');
    $active_menu->ref = null;
    $views = 'web.search';
    $slider = [];
    $slider_bottom = [];
    $nav_lang = [];
    // dd($nav);
    $keyword = $request->query('keyword');
    $page = Page::where('lang', '=', $locale)->where('content', 'like', '%'.$keyword.'%')
            ->select('id_menu as id', 'content')
            ->get();
    $result = [];
    foreach ($page as $key => $value) {
        $menu = $this->findHref(array_merge($nav, $nav_right), $value->id);
        $value['href'] = isset($menu->href) ? $menu->href : '';
        $value['title'] = isset($menu->title) ? $this->highlightWords($menu->title, $keyword) : '';
        $content = trim(str_replace(array("\r\n", "\r", "\n"), " ", strip_tags(html_entity_decode($value->content))));
        $value['content'] = $this->limit_text($content, 50, $keyword);
        $result['Pages'][] = json_decode($value->toJson());
    }
    return view($views, compact('locale', 'result', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu', 'slider', 'slider_bottom'));
  }


  static function rederHomeInvestors($locale)
  {
    $ebook = AnnualReport::where('lang', $locale)->orderBy('title', 'DESC')->take(6)->get();
    return view('web.render-modules.home-investors', compact('locale', 'ebook'));
  }

  static function rederHomeNews($locale)
  {
    $category = Category::where('lang', $locale)->where('type', 'news')->get();
    return view('web.render-modules.home-news', compact('locale', 'category'));
  }

  static function rederProfileTimelines($locale)
  {
    $timeline = Timeline::where('lang', $locale)->get();
    return view('web.render-modules.profile-timelines', compact('timeline'));
  }

  static function rederDewanKomisaris($locale)
  {
    $data = Management::where('lang', $locale)->where('board', 'commissioner')->get();
    return view('web.render-modules.management', compact('data'));
  }

  static function rederDireksi($locale)
  {
    $data = Management::where('lang', $locale)->where('board', 'directors')->get();
    return view('web.render-modules.management', compact('data'));
  }

  static function rederSekper($locale)
  {
    $data = Management::where('lang', $locale)->where('board', 'secretary')->get();
    return view('web.render-modules.management', compact('data'));
  }

  static function rederAward($locale)
  {
    $year = Certificate::select('year')->where('lang', $locale)->orderBy('year', 'DESC')->groupBy('year')->get();
    return view('web.render-modules.certificate-award', compact('year', 'locale'));
  }

  static function rederProgramTJSL($locale)
  {
    return view('web.render-modules.tjsl', compact('locale'));
  }
  static function rederProgramEmpowerment($locale)
  {
    return view('web.render-modules.empowerment', compact('locale'));
  }

  static function rederKeberlanjutan($locale)
  {
    $ebook = SustainabilityReport::where('lang', $locale)->orderBy('title', 'DESC')->get();
    return view('web.render-modules.laporan-laporan', compact('ebook'));
  }

  static function rederTahunan($locale)
  {
    $ebook = AnnualReport::where('lang', $locale)->orderBy('title', 'DESC')->get();
    return view('web.render-modules.laporan-laporan', compact('ebook'));
  }

  static function rederEMagazine($locale)
  {
    $year = Emagazine::select('year')->where('lang', $locale)->orderBy('year', 'DESC')->groupBy('year')->get();
    return view('web.render-modules.e-magazine', compact('locale', 'year'));
  }

  static function rederKeuangan($locale)
  {
    $ebook = FinancialReport::where('lang', $locale)->orderBy('title', 'DESC')->get();
    return view('web.render-modules.laporan-laporan', compact('ebook'));
  }

  static function rederContact($locale)
  {
    $contact = Contact::where('lang', $locale)->get();
    $captcha = count($contact) ? reCaptcha() : '';
    return view('web.render-modules.contact', compact('contact', 'captcha'));
  }

  static function rederNews($locale)
  {
    $category = Category::where('lang', $locale)->where('type', 'news')->get();
    return view('web.render-modules.news', compact('locale', 'category'));
  }

  static function rederNewsCovid($locale)
  {
    $category = Category::where('lang', $locale)->where('type', 'news')->get();
    return view('web.render-modules.news-covid', compact('locale', 'category'));
  }

  static function rederGallery($locale)
  {
    $category = Gallery::select('type', 'type as title')->groupBy('type')->get();
    $year = Gallery::select('year')->where('lang', $locale)->orderBy('year', 'DESC')->groupBy('year')->get();
    return view('web.render-modules.gallery', compact('locale', 'category', 'year'));
  }

  static function rederProduct($locale, $product)
  {
    $product = Product::where('lang', $locale)->where('product', $product)->get();
    return view('web.render-modules.product', compact('locale', 'product'));
  }

  public function getNews(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $category = $request->category ? "id_category='" . $request->category . "'" : "id_category!=''";
    $data = News::
    where('lang', $request->locale)
    ->where('active_date', '<=', date('Y-m-d'))
    ->where(function($q) {
        $q->whereNull('exp_date')
          ->orWhere('exp_date', '>=', date('Y-m-d'));
    })
    ->whereRaw($category)
    ->orderBy('active_date', 'DESC')
    ->paginate($request->limit);
    $news = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        $value->url = route('web.page-det', [$request->locale, 'news-detail', $value->url]);
        $value->image = url('public' . $value->image);
        $value->active_date = date('d M Y', strtotime($value->active_date));
        $value->category = Category::where('id', $value->id_category)->first()->title;
        $news[] = $value;
      }
    }
    $data->items($news);
    $_response['data'] = $data;
    if (isset($request->placement) && $request->placement == "home"){
        $_response['blade'] = view('web.render-modules.home-news-card', compact('data'))->render();
    }else{
        $_response['blade'] = view('web.render-modules.news-card', compact('data'))->render();
    }
    return response()->json($_response);
  }

  public function getCertificate(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $year = $request->year ? "year='" . $request->year . "'" : "year IS NOT NULL";
    $category = $request->category ? "category='" . $request->category . "'" : "category IS NOT NULL";
    $data = Certificate::where('lang', $request->locale)->whereRaw($year)->whereRaw($category)->orderBy('created_at', 'DESC')->paginate($request->limit);
    $cert = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        $value->image = url('public' . $value->image);
        $cert[] = $value;
      }
    }
    $data->items($cert);
    $_response['data'] = $data;
    $_response['card'] = view('web.render-modules.certificate-card', compact('data'))->render();
    $_response['card-detail'] = view('web.render-modules.certificate-card-detail', compact('data'))->render();
    return response()->json($_response);
  }

  public function getTjsl(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $data = ProgramTjsl::where('lang', $request->locale)->orderBy('reorder')->paginate($request->limit);
    $cert = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        $value->image = url('public' . $value->image);
        $cert[] = $value;
      }
    }
    $data->items($cert);
    $_response['data'] = $data;
    $_response['card'] = view('web.render-modules.tjsl-card', compact('data'))->render();
    $_response['card-detail'] = view('web.render-modules.tjsl-card-detail', compact('data'))->render();
    return response()->json($_response);
  }
  public function getEmpowerment(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $data = ProgramEmpowerment::where('lang', $request->locale)->orderBy('reorder')->paginate($request->limit);
    $cert = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        $value->image = url('public' . $value->image);
        $cert[] = $value;
      }
    }
    $data->items($cert);
    $_response['data'] = $data;
    $_response['card'] = view('web.render-modules.empowerment-card', compact('data'))->render();
    $_response['card-detail'] = view('web.render-modules.empowerment-card-detail', compact('data'))->render();
    return response()->json($_response);
  }

  public function getGallery(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $category = $request->category ? "type='" . $request->category . "'" : "type!=''";
    $year = $request->year ? "year='" . $request->year . "'" : "year!=''";
    $data = Gallery::where('lang', $request->locale)->whereRaw($year)->whereRaw($category)->orderBy('created_at', 'DESC')->paginate($request->limit);
    $cert = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        if ($value->type == "image") {
          $value->image = url('public' . $value->media);
          $value->media = url('public' . $value->media);
        } else {
          $value->image = "http://img.youtube.com/vi/" . $value->media . "/sddefault.jpg";
          $value->media = "https://www.youtube.com/watch?v=" . $value->media;
        }
        $cert[] = $value;
      }
    }
    $data->items($cert);
    $_response['data'] = $data;
    $_response['card'] = view('web.render-modules.gallery-card', compact('data'))->render();
    return response()->json($_response);
  }
  public function getEMagazine(Request $request)
  {
    $_response = array("status" => "200", "messages" => [], "data" => []);
    $_response['messages'] = "Data Found";
    $year = $request->year ? "year='" . $request->year . "'" : "year!=''";
    $data = Emagazine::where('lang', $request->locale)->whereRaw($year)->orderBy('reorder')->paginate($request->limit);
    $cert = [];
    if ($data->count() > 0) {
      foreach ($data->items() as $key => $value) {
        $value->image = url('public' . $value->image);

        $file = explode('/', $value->file);
        $file = end($file);
        $dir = str_replace($file, '', $value->file);
        $value->file = route('ebook.index') . "/" . $file . '?v=' . base64_encode($dir);
        $cert[] = $value;
      }
    }
    $data->items($cert);
    $_response['data'] = $data;
    $_response['blade'] = view('web.render-modules.e-magazine-card', compact('data'))->render();
    return response()->json($_response);
  }

  public function sendContact(Request $request)
  {
    $store  = $request->all();
    $validator = Validator::make($store, [
      'captcha' => 'required',
      'subject' => 'required',
      'tujuan' => 'required',
      'name' => 'required',
      'email' => 'required|email',
      'ktp' => 'required',
      'phone' => 'required',
      'message' => 'required',
      'ktp_file' => 'required|max:500',
    ]);

    $captcha_code = session('captcha_code');
    $validator->after(function ($validator) use ($request, $captcha_code) {
      if (strtolower($request->captcha) != strtolower($captcha_code)) {
        $validator->errors()->add('captcha', 'Captcha tidak sesuai');
      }
    });
    if ($validator->fails()) {
      return redirect(url()->previous() . "#form")->withErrors($validator)->withInput();
    }

    $ktp_name = date('YmdHis') . $request->ktp_file->getClientOriginalName();
    $request->ktp_file->storeAs('public', $ktp_name);
    $body = $store;
    $body['msg'] = $store['message'];
    $body['logo'] = public_path('assets/files/img/logodasar.png');
    $body['ktp_image'] = storage_path('app/public/') . $ktp_name;
    unset($body['message']);
    $dataEmail = [];
    $dataEmail['body'] = $body;
    $dataEmail['view'] = "mail.contact";
    $dataEmail['subject'] = $store['subject'];
    $dataEmail = json_decode(json_encode($dataEmail));

    $mailto = "sangrezha@gmail.com";
    Mail::to($mailto)->send(new SendEmailController($dataEmail));
    Storage::disk('public')->delete($ktp_name);
    return redirect(url()->previous() . "#form")->with('success_submit_contact', 'Terima kasih, inkuiri anda akan segera kami balas melalui email.');
  }
}
