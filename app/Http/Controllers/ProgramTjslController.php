<?php


namespace App\Http\Controllers;

use App\ProgramTjsl;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ProgramTjslController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:program-tjsl-list', ['only' => ['index','show']]);
         $this->middleware('permission:program-tjsl-create', ['only' => ['create','store']]);
         $this->middleware('permission:program-tjsl-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:program-tjsl-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'program-tjsl';
        $page['can'] = 'program-tjsl';
        $page['title'] = 'Program TJSL Management';
        return view('webmin.program-tjsl.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            ProgramTjsl::reorderData($request);
        }
        $getData = ProgramTjsl::getData($request);
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
        $page['page'] = 'program-tjsl';
        $page['title'] = 'Program TJSL Management';
        $page['method'] = 'POST';
        $page['action'] = route('program-tjsl.store');
        return view('webmin.program-tjsl.form',compact('page'));
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
            'content' => 'required',
        ]);
        $store  = $request->all();
        $store['ref'] =  (ProgramTjsl::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = ProgramTjsl::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            ProgramTjsl::create($store);
        }

        return redirect()->route('program-tjsl.index')
                        ->with('success','Program TJSL created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramTjsl  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramTjsl $program_tjsl)
    {
        $page['page'] = 'program-tjsl';
        $page['title'] = 'Program TJSL Management';
        $page['method'] = 'PUT';
        $page['action'] = route('program-tjsl.update',$program_tjsl->id);
        return view('webmin.program-tjsl.form',compact('program_tjsl','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramTjsl  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramTjsl $program_tjsl)
    {
        request()->validate([
            'title' => 'required',
            'image' => 'required',
            'content' => 'required',
        ]);

        $store  = $request->all();
        $program_tjsl->update($store);
        return redirect()->route('program-tjsl.index')
                        ->with('success','Program TJSL updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramTjsl  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramTjsl $program_tjsl)
    {
        $program_tjsl->delete();
        return redirect()->route('program-tjsl.index')
                        ->with('success','Program TJSL deleted successfully');
    }
}
