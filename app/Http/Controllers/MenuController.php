<?php


namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class MenuController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:menu-list', ['only' => ['index','show']]);
         $this->middleware('permission:menu-create', ['only' => ['create','store']]);
         $this->middleware('permission:menu-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'menus';
        $page['can'] = 'menu';
        $page['title'] = 'Menu Management';
        return view('webmin.menus.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Menu::reorderData($request);
        }
        $getData = Menu::getData($request);
        $query = $getData['query'];

        return DataTables::of($query)
        ->addIndexColumn()
        ->filter(function ($query) use ($request, $getData) {
            $this->filterGlobal($getData, $request, $query);
        })
        ->skipTotalRecords()
        ->setTotalRecords(false)
        ->setFilteredRecords(false)
        ->make(true);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page['page'] = 'menus';
        $page['title'] = 'Menu Management';
        $page['method'] = 'POST';
        $page['action'] = route('menus.store');
        $parent = Menu::where('lang', '=', config('app.fallback_locale'))->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        return view('webmin.menus.form',compact('parent','page'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'menu_type' => 'required',
        ]);
        $store  = $request->all();
        $alias = str_slug($request->title, '-');
        $store['alias'] =  $alias;
        $store['href'] =  $store['link'];
        $max_ref = Menu::max('ref');
        $store['ref'] =  ($max_ref ? $max_ref : 0) + 1;
        $ref = Menu::where('id', '=', $store['id_menu'])->select('ref')->pluck('ref')->first();
        foreach (config('app.locales') as $lang) {
            if ($store['id_menu']) {
                $id_menu = Menu::where('lang', '=', $lang)->where('ref', '=', $ref)->select('id')->pluck('id')->first();
                $store['id_menu'] =  $id_menu;
            }
            $reorder = Menu::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder ? $reorder : 0) + 1;
            Menu::create($store);
        }

        return redirect()->route('menus.index')
                        ->with('success','Menu created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return view('webmin.menus.show',compact('menu'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $page['page'] = 'menus';
        $page['title'] = 'Menu Management';
        $page['method'] = 'PUT';
        $page['action'] = route('menus.update',$menu->id);
        $parent = Menu::where('lang', '=', $menu->lang)->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        return view('webmin.menus.form',compact('menu','parent','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        request()->validate([
            'title' => 'required',
            'menu_type' => 'required',
        ]);

        $store  = $request->all();
        $menu->update($store);
        return redirect()->route('menus.index')
                        ->with('success','Menu updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')
                        ->with('success','Menu deleted successfully');
    }
}