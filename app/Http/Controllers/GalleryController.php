<?php


namespace App\Http\Controllers;

use App\Category;
use App\Gallery;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class GalleryController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:gallery-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:gallery-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:gallery-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:gallery-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'galleries';
        $page['can'] = 'page';
        $page['title'] = 'Gallery Management';
        return view('webmin.galleries.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Gallery::reorderData($request);
        }
        $getData = Gallery::getData($request);
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
        $page['page'] = 'galleries';
        $page['title'] = 'Gallery Management';
        $page['method'] = 'POST';
        $page['action'] = route('galleries.store');
        return view('webmin.galleries.form',compact('page'));
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
            'year' => 'required',
        ]);
        $store  = $request->all();
        $store['ref'] =  (Gallery::max('ref') || 0) + 1;

        if ($store['type'] == "video") {
            $media = str_replace('https://youtu.be/', '', $store['video']);
        } else {
            $media = $store['image'];
        }
        $store['media'] = $media;
        foreach (config('app.locales') as $lang) {
            $reorder = Gallery::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder ? $reorder : 0) + 1;
            Gallery::create($store);
        }

        return redirect()->route('galleries.index')
                        ->with('success','Gallery created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Gallery  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        $page['page'] = 'galleries';
        $page['title'] = 'Gallery Management';
        $page['method'] = 'PUT';
        $page['action'] = route('galleries.update',$gallery->id);
        return view('webmin.galleries.form',compact('gallery','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Gallery  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        request()->validate([
            'title' => 'required',
            'year' => 'required',
        ]);

        $store  = $request->all();
        if ($store['type'] == "video") {
            $media = str_replace('https://youtu.be/', '', $store['video']);
        } else {
            $media = $store['image'];
        }
        $store['media'] = $media;
        $gallery->update($store);
        return redirect()->route('galleries.index')
                        ->with('success','Gallery updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Gallery  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route('galleries.index')
                        ->with('success','Gallery deleted successfully');
    }
}
