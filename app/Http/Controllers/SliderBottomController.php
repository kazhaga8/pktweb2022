<?php


namespace App\Http\Controllers;


use App\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderBottomController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:sliders-bottom-list', ['only' => ['index','show']]);
         $this->middleware('permission:sliders-bottom-create', ['only' => ['create','store']]);
         $this->middleware('permission:sliders-bottom-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sliders-bottom-delete', ['only' => ['destroy']]);
    }
    

    public function json(){
        return DataTables::of(Slider::where('position', '=', 'bottom')->orderBy('created_at', 'DESC'))->addIndexColumn()->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'sliders-bottom';
        $page['can'] = 'slider';
        $page['title'] = 'Sliders Bottom Management';
        return view('webmin.sliders-bottom.index',compact('page'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page['page'] = 'sliders-bottom';
        $page['title'] = 'Sliders Bottom Management';
        $page['method'] = 'POST';
        $page['action'] = route('sliders-bottom.store');
        return view('webmin.sliders-bottom.form',compact('page'));
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
            'image' => 'required',
        ]);
        $store  = $request->all();
        foreach (config('app.locales') as $lang) {
            $reorder = Slider::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Slider::create($store);
        }


        return redirect()->route('sliders-bottom.index')
                        ->with('success','Slider created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $sliders_bottom)
    {
        return view('webmin.sliders-bottom.show',compact('slider'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $sliders_bottom)
    {
        $page['page'] = 'sliders-bottom';
        $page['title'] = 'Sliders Bottom Management';
        $page['method'] = 'PUT';
        $page['action'] = route('sliders-bottom.update',$sliders_bottom->id);
        return view('webmin.sliders-bottom.form',compact('slider','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $sliders_bottom)
    {
         request()->validate([
            'title' => 'required',
        ]);

        $store  = $request->all();
        $sliders_bottom->update($store);


        return redirect()->route('sliders-bottom.index')
                        ->with('success','Slider updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $sliders_bottom)
    {
        $sliders_bottom->delete();
        return redirect()->route('sliders-bottom.index')
                        ->with('success','Slider deleted successfully');
    }
}