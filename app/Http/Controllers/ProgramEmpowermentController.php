<?php


namespace App\Http\Controllers;

use App\ProgramEmpowerment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ProgramEmpowermentController extends Controller
{ 
    function __construct()
    {
        //  $this->middleware('permission:program-empowerment-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:program-empowerment-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:program-empowerment-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:program-empowerment-delete', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'program-empowerment';
        $page['can'] = 'page';
        $page['title'] = 'Program Pemberdayaan Masyarakat Management';
        return view('webmin.program-empowerment.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            ProgramEmpowerment::reorderData($request);
        }
        $getData = ProgramEmpowerment::getData($request);
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
        $page['page'] = 'program-empowerment';
        $page['title'] = 'Program Pemberdayaan Masyarakat Management';
        $page['method'] = 'POST';
        $page['action'] = route('program-empowerment.store');
        return view('webmin.program-empowerment.form',compact('page'));
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
        $store['ref'] =  (ProgramEmpowerment::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = ProgramEmpowerment::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            ProgramEmpowerment::create($store);
        }

        return redirect()->route('program-empowerment.index')
                        ->with('success','Program Pemberdayaan Masyarakat created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProgramEmpowerment  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramEmpowerment $program_empowerment)
    {
        $page['page'] = 'program-empowerment';
        $page['title'] = 'Program Pemberdayaan Masyarakat Management';
        $page['method'] = 'PUT';
        $page['action'] = route('program-empowerment.update',$program_empowerment->id);
        return view('webmin.program-empowerment.form',compact('program-empowerment','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProgramEmpowerment  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramEmpowerment $program_empowerment)
    {
        request()->validate([
            'title' => 'required',
            'image' => 'required',
            'content' => 'required',
        ]);

        $store  = $request->all();
        $program_empowerment->update($store);
        return redirect()->route('program-empowerment.index')
                        ->with('success','Program Pemberdayaan Masyarakat updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProgramEmpowerment  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramEmpowerment $program_empowerment)
    {
        $program_empowerment->delete();
        return redirect()->route('program-empowerment.index')
                        ->with('success','Program Pemberdayaan Masyarakat deleted successfully');
    }
}