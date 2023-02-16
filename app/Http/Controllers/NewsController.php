<?php

namespace App\Http\Controllers;

use App\Category;
use App\News;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:news-list', ['only' => ['index','store']]);
         $this->middleware('permission:news-create', ['only' => ['create','store']]);
         $this->middleware('permission:news-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }


    public function json(){
        return DataTables::of(News::orderBy('id','DESC'))->addIndexColumn()->make(true);
    }

    public function index(Request $request)
    {
        $page['page'] = 'news';
        $page['can'] = 'page';
        $page['title'] = 'News Management';
        return view('webmin.news.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'news';
        $page['title'] = 'News Management';
        $page['method'] = 'POST';
        $page['action'] = route('news.store');
        $parent = Category::where('lang', '=', config('app.fallback_locale'))->where('type', 'news')->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        return view('webmin.news.form',compact('parent','page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $store['ref'] =  (News::max('ref') || 0) + 1;
        $alias = str_slug($request->title, '-');
        $store['url'] =  $alias;
        $store['active_date'] = implode('-', array_reverse(explode('/', $store['active_date'])));
        $store['exp_date'] = $store['exp_date'] ? implode('-', array_reverse(explode('/', $store['exp_date']))) : NULL;
        $store['content'] = htmlentities($store['content']);
        $ref = Category::where('id', '=', $store['id_category'])->select('ref')->pluck('ref')->first();
        foreach (config('app.locales') as $lang) {
            if ($store['id_category']) {
                $id_category = Category::where('lang', '=', $lang)->where('ref', '=', $ref)->select('id')->pluck('id')->first();
                $store['id_category'] =  $id_category;
            }
            $reorder = News::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder ? $reorder : 0) + 1;
            News::create($store);
        }

        return redirect()->route('news.index')
                        ->with('success','News created successfully.');
    }

    public function edit(News $news)
    {
        $page['page'] = 'news';
        $page['title'] = 'News Management';
        $page['method'] = 'PUT';
        $page['action'] = route('news.update',$news->id);
        $parent = Category::where('lang', '=', $news->lang)->where('type', 'news')->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        $news->content = html_entity_decode($news->content);
        return view('webmin.news.form',compact('parent','page', 'news'));
    }
    public function update(Request $request, News $news)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $store  = $request->all();
        $alias = str_slug($request->title, '-');
        $store['url'] =  $alias;
        $store['active_date'] = implode('-', array_reverse(explode('/', $store['active_date'])));
        $store['exp_date'] = $store['exp_date'] ? implode('-', array_reverse(explode('/', $store['exp_date']))) : NULL;
        $news->update($store);
        return redirect()->route('news.index')
                        ->with('success','News updated successfully');
    }
    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->route('news.index')
                        ->with('success','News deleted successfully');
    }
}
