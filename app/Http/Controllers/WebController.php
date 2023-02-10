<?php

namespace App\Http\Controllers;

use App\Config;
use App\Contact;
use App\Menu;
use App\MenuShortcut;
use App\Page;
use App\Slider;
use App\SliderBottom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
  public function getMenu($locale, $position)
  {
    return Menu::select(
      'id',
      'ref',
      'banner_img',
      'lang',
      'alias',
      'title',
      'href',
      'menu_type',
    )
      ->where('lang', '=', $locale)
      ->where('menu_position', '=', $position)
      ->orderBy('reorder', 'ASC');
  }

  public function getHref($data, $url_parent)
  {
    $url = "";

    if ($data['menu_type'] == "internal") {
      $url = route('web.index', [$data['lang'], $data['alias']]);
    }
    if ($data['menu_type'] == "anchor") {
      $url = route('web.index', [$data['lang'], $url_parent . "#" . $data['alias']]);
    }
    if ($data['menu_type'] == "external") {
      $url = $data['href'];
    }

    return $url;
  }

  public function generateMenu($locale, $position)
  {
    $nav = [];
    $nav1 = $this->getMenu($locale, $position)->whereNull('id_menu')->get()->toArray();
    foreach ($nav1 as $lvl1) {
      $nav2 = $this->getMenu($locale, $position)->where('id_menu', '=', $lvl1['id'])->get()->toArray();
      foreach ($nav2 as $lvl2) {
        $nav3 = $this->getMenu($locale, $position)->where('id_menu', '=', $lvl2['id'])->get()->toArray();
        foreach ($nav3 as $lvl3) {
          $nav4 = $this->getMenu($locale, $position)->where('id_menu', '=', $lvl3['id'])->get()->toArray();
          foreach ($nav4 as $lvl4) {
            $lvl4['href'] = $this->getHref($lvl4, $lvl3['alias']);
            $lvl3['child'][] = $lvl4;
          }
          $lvl3['href'] = $this->getHref($lvl3, $lvl2['alias']);
          $lvl2['child'][] = $lvl3;
        }
        $lvl2['href'] = $this->getHref($lvl2, $lvl1['alias']);
        $lvl1['child'][] = $lvl2;
      }
      $lvl1['href'] = isset($lvl1['child']) && count($lvl1['child']) ? $lvl1['child'][0]['href'] : route('web.index', [$locale, $lvl1['alias']]);
      $nav[] = $lvl1;
    }
    return json_decode(json_encode($nav));
  }

  public function getActiveMenu($nav, $menu_id)
  {
    $active_menu = null;
    foreach ($nav as $lvl1) {
      if ($lvl1->id == $menu_id) {
        $active_menu = $lvl1;
      } else {
        if (isset($lvl1->child)) {
          foreach ($lvl1->child as $levl2) {
            if ($levl2->id == $menu_id) {
              $active_menu = $levl2;
            } else {
              if (isset($levl2->child)) {
                foreach ($levl2->child as $lvl3) {
                  if ($lvl3->id == $menu_id) {
                    $active_menu = $lvl3;
                  } else {
                    if (isset($lvl3->child)) {
                      foreach ($lvl3->child as $lvl4) {
                        if ($lvl4->id == $menu_id) {
                          $active_menu = $lvl4;
                        }
                      }
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
    return $active_menu;
  }

  public function index($locale, $pages)
  {
    $config = Config::first()->toArray();
    $nav = $this->generateMenu($locale, 'main');
    $nav_right = $this->generateMenu($locale, 'right');
    $nav_shortcut = MenuShortcut::where('lang', '=', $locale)->get();
    $menu = Menu::where('lang', '=', $locale)->where('alias', '=', $pages)->firstOrFail();
    $menu_id = $menu->id;
    $nav_lang = Menu::where('ref', '=', $menu->ref)->get()->toArray();
    if (!$menu_id) {
      return abort(404, 'page not found.');
    }
    $active_menu = $this->getActiveMenu($menu->menu_position == 'main' ? $nav : $nav_right, $menu_id);
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
      return view('web.coming-soon', compact('pages', 'locale', 'config', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu'));
    }
    return view('web.pages', compact('pages', 'locale', 'config', 'nav', 'nav_right', 'nav_shortcut', 'nav_lang', 'active_menu', 'slider', 'slider_bottom'));
  }

  static function rederHomeInvestors()
  {
    return view('web.render-modules.home-investors');
  }

  static function rederHomeNews()
  {
    return view('web.render-modules.home-news');
  }

  static function rederProfileTimelines()
  {
    return view('web.render-modules.profile-timelines');
  }

  static function rederDewanKomisaris()
  {
    return view('web.render-modules.dewan-komisaris');
  }

  static function rederDireksi()
  {
    return view('web.render-modules.direksi');
  }

  static function rederSekper()
  {
    return view('web.render-modules.sekper');
  }

  static function rederAward()
  {
    return view('web.render-modules.certificate-award');
  }

  static function rederKeberlanjutan()
  {
    return view('web.render-modules.laporan-laporan');
  }

  static function rederTahunan()
  {
    return view('web.render-modules.laporan-laporan');
  }

  static function rederKeuangan()
  {
    return view('web.render-modules.laporan-laporan');
  }

  static function rederContact($locale)
  {
    $contact = Contact::where('lang', $locale)->get();
    $captcha = count($contact) ? reCaptcha() : '';
    return view('web.render-modules.contact', compact('contact', 'captcha'));
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

    $ktp_name = date('YmdHis').$request->ktp_file->getClientOriginalName();
    $request->ktp_file->storeAs('public', $ktp_name);
    $body = $store;
    $body['msg'] = $store['message'];
    $body['logo'] = public_path('assets/files/img/logodasar.png');
    $body['ktp_image'] = storage_path('app/public/').$ktp_name;
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
