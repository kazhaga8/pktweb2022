<?php


namespace App\Http\Controllers;

use App\MenuShortcut;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ShortcutController extends Controller
{ 
    function __construct()
    {
        //  $this->middleware('permission:shortcut-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:shortcut-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:shortcut-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:shortcut-delete', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'shortcuts';
        $page['can'] = 'page';
        $page['title'] = 'Shortcut Menu Management';
        return view('webmin.shortcuts.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            MenuShortcut::reorderData($request);
        }
        $getData = MenuShortcut::getData($request);
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
        $page['page'] = 'shortcuts';
        $page['title'] = 'Shortcut Menu Management';
        $page['method'] = 'POST';
        $page['action'] = route('shortcuts.store');
        $parent = MenuShortcut::where('lang', '=', config('app.fallback_locale'))->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        return view('webmin.shortcuts.form',compact('parent','page'));
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
            'link' => 'required',
        ]);
        $store  = $request->all();
        $store['menu_position'] =  'shortcut';
        $store['href'] =  $store['link'];
        $store['ref'] =  (MenuShortcut::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = MenuShortcut::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            MenuShortcut::create($store);
        }

        return redirect()->route('shortcuts.index')
                        ->with('success','Shortcut Menu created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuShortcut  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuShortcut $shortcut)
    {
        $page['page'] = 'shortcuts';
        $page['title'] = 'Shortcut Menu Management';
        $page['method'] = 'PUT';
        $page['action'] = route('shortcuts.update',$shortcut->id);
        $parent = MenuShortcut::where('lang', '=', $shortcut->lang)->get(['id', 'title as name']);
        $parent = json_decode(json_encode($parent));
        return view('webmin.shortcuts.form',compact('shortcut','parent','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuShortcut $shortcut)
    {
        request()->validate([
            'title' => 'required',
            'link' => 'required',
        ]);

        $store  = $request->all();
        $store['href'] =  $store['link'];
        $shortcut->update($store);
        return redirect()->route('shortcuts.index')
                        ->with('success','Shortcut Menu updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuShortcut $shortcut)
    {
        $shortcut->delete();
        return redirect()->route('shortcuts.index')
                        ->with('success','Shortcut Menu deleted successfully');
    }
}