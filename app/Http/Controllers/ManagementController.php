<?php


namespace App\Http\Controllers;

use App\Management;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ManagementController extends Controller
{
    public $boards;
    function __construct()
    {
         $this->middleware('permission:management-list', ['only' => ['index','show']]);
         $this->middleware('permission:management-create', ['only' => ['create','store']]);
         $this->middleware('permission:management-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:management-delete', ['only' => ['destroy']]);

        $boards = [
            ["id" => "commissioner", "name" => "DEWAN KOMISARIS"],
            ["id" => "directors", "name" => "DIREKSI"],
            ["id" => "secretary", "name" => "SEKRETARIS PERUSAHAAN"]
        ];
        $this->boards = json_decode(json_encode($boards));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'managements';
        $page['can'] = 'management';
        $page['title'] = 'Directors Management';
        return view('webmin.managements.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Management::reorderData($request);
        }
        $getData = Management::getData($request);
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
        $page['page'] = 'managements';
        $page['title'] = 'Directors Management';
        $page['method'] = 'POST';
        $page['action'] = route('managements.store');
        $boards = $this->boards;
        return view('webmin.managements.form',compact('page', 'boards'));
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
            'name' => 'required',
            'board' => 'required',
            'position' => 'required',
            'description' => 'required',
            'profile_pic' => 'required',
            'image' => 'required',
        ]);
        $store  = $request->all();
        $store['ref'] =  (Management::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Management::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Management::create($store);
        }

        return redirect()->route('managements.index')
                        ->with('success','Directors created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Management  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Management $management)
    {
        $page['page'] = 'managements';
        $page['title'] = 'Directors Management';
        $page['method'] = 'PUT';
        $page['action'] = route('managements.update',$management->id);
        $boards = $this->boards;
        return view('webmin.managements.form',compact('management','page', 'boards'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Management  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Management $management)
    {
        request()->validate([
            'name' => 'required',
            'board' => 'required',
            'position' => 'required',
            'description' => 'required',
            'profile_pic' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $management->update($store);
        return redirect()->route('managements.index')
                        ->with('success','Directors updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Management  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Management $management)
    {
        $management->delete();
        return redirect()->route('managements.index')
                        ->with('success','Directors deleted successfully');
    }
}
