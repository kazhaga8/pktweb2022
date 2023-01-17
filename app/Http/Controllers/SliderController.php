<?php


namespace App\Http\Controllers;


use App\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{ 
    function __construct()
    {
         $this->middleware('permission:slider-list', ['only' => ['index','show']]);
         $this->middleware('permission:slider-create', ['only' => ['create','store']]);
         $this->middleware('permission:slider-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:slider-delete', ['only' => ['destroy']]);
    }
    

    public function json(){
        return DataTables::of(Slider::where('position', '=', 'top')->orderBy('created_at', 'DESC'))->addIndexColumn()->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'sliders';
        $page['can'] = 'slider';
        $page['title'] = 'Sliders Management';
        return view('webmin.sliders.index',compact('page'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page['page'] = 'sliders';
        $page['title'] = 'Sliders Management';
        $page['method'] = 'POST';
        $page['action'] = route('sliders.store');
        return view('webmin.sliders.form',compact('page'));
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
            'description' => 'required',
            'image' => 'required',
        ]);
        $store  = $request->all();
        foreach (config('app.locales') as $lang) {
            $reorder = Slider::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Slider::create($store);
        }


        return redirect()->route('sliders.index')
                        ->with('success','Slider created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        return view('webmin.sliders.show',compact('slider'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        $page['page'] = 'sliders';
        $page['title'] = 'Sliders Management';
        $page['method'] = 'PUT';
        $page['action'] = route('sliders.update',$slider->id);
        return view('webmin.sliders.form',compact('slider','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
         request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $store  = $request->all();
        $slider->update($store);


        return redirect()->route('sliders.index')
                        ->with('success','Slider updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('sliders.index')
                        ->with('success','Slider deleted successfully');
    }
}