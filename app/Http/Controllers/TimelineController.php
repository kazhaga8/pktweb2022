<?php


namespace App\Http\Controllers;

use App\Timeline;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class TimelineController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:timeline-list', ['only' => ['index','show']]);
         $this->middleware('permission:timeline-create', ['only' => ['create','store']]);
         $this->middleware('permission:timeline-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:timeline-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'timelines';
        $page['can'] = 'timeline';
        $page['title'] = 'Timeline Management';
        return view('webmin.timelines.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Timeline::reorderData($request);
        }
        $getData = Timeline::getData($request);
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
        $page['page'] = 'timelines';
        $page['title'] = 'Timeline Management';
        $page['method'] = 'POST';
        $page['action'] = route('timelines.store');
        return view('webmin.timelines.form',compact('page'));
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
            'image' => 'required',
        ]);
        $store  = $request->all();
        $max_ref = Timeline::max('ref');
        $store['ref'] =  ($max_ref ? $max_ref : 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Timeline::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder ? $reorder : 0) + 1;
            Timeline::create($store);
        }

        return redirect()->route('timelines.index')
                        ->with('success','Timeline created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timeline  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Timeline $timeline)
    {
        $page['page'] = 'timelines';
        $page['title'] = 'Timeline Management';
        $page['method'] = 'PUT';
        $page['action'] = route('timelines.update',$timeline->id);
        return view('webmin.timelines.form',compact('timeline','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timeline  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Timeline $timeline)
    {
        request()->validate([
            'title' => 'required',
            'year' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $timeline->update($store);
        return redirect()->route('timelines.index')
                        ->with('success','Timeline updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timeline  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timeline $timeline)
    {
        $timeline->delete();
        return redirect()->route('timelines.index')
                        ->with('success','Timeline deleted successfully');
    }
}
