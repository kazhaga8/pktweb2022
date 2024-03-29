<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Page;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PageController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:page-list', ['only' => ['index','store']]);
         $this->middleware('permission:page-create', ['only' => ['create','store']]);
         $this->middleware('permission:page-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:page-delete', ['only' => ['destroy']]);
    }


    public function json(Request $request){
        $getData = Page::getData($request);
        $query = $getData['query'];

        return DataTables::of($query)
        ->addIndexColumn()
        ->filter(function ($query) use ($request, $getData) {
            $this->filterGlobal($getData, $request, $query);
        })
        ->addColumn('menu', function(Page $page) {
            $menus = selectMenu($page->lang);
            $key = array_search($page->id_menu, array_column($menus, 'id'));
            return $menus[$key]->name;
        })
        ->skipTotalRecords()
        ->setTotalRecords(false)
        ->setFilteredRecords(false)
        ->make(true);
    }

    public function index(Request $request)
    {
        $page['page'] = 'pages';
        $page['can'] = 'page';
        $page['title'] = 'Pages Management';
        return view('webmin.pages.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'pages';
        $page['title'] = 'Pages Management';
        $page['method'] = 'POST';
        $page['action'] = route('pages.store');
        $parent = selectMenu(config('app.fallback_locale'));
        return view('webmin.pages.form',compact('parent','page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $store['ref'] =  (Page::max('ref') || 0) + 1;
        $anchor = Menu::find($store['id_menu']);
        if ($anchor->menu_type == "anchor") {
            $store['content'] = setSectionAnchor($store['content'], $anchor->alias);
        }
        $store['content'] = htmlentities($store['content']);
        $ref = Menu::where('id', '=', $store['id_menu'])->select('ref')->pluck('ref')->first();
        foreach (config('app.locales') as $lang) {
            if ($store['id_menu']) {
                $id_menu = Menu::where('lang', '=', $lang)->where('ref', '=', $ref)->select('id')->pluck('id')->first();
                $store['id_menu'] =  $id_menu;
            }
            $store['lang'] =  $lang;
            Page::create($store);
        }

        return redirect()->route('pages.index')
                        ->with('success','Pages created successfully.');
    }

    public function edit(Page $page)
    {
        $page_['page'] = 'pages';
        $page_['title'] = 'Pages Management';
        $page_['method'] = 'PUT';
        $page_['action'] = route('pages.update',$page->id);
        $parent = selectMenu($page->lang);
        $page->content = html_entity_decode($page->content);
        return view('webmin.pages.form',compact('parent'), [ 'page' => $page_, 'pages' => $page ]);
    }
    public function update(Request $request, Page $page)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $store  = $request->all();
        $anchor = Menu::find($store['id_menu']);
        if ($anchor->menu_type == "anchor") {
            $store['content'] = setSectionAnchor($store['content'], $anchor->alias);
        }
        $store['content'] = htmlentities($store['content']);
        $page->update($store);
        return redirect()->route('pages.index')
                        ->with('success','Pages updated successfully');
    }
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')
                        ->with('success','Pages deleted successfully');
    }
}
