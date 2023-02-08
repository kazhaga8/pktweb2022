<?php


namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class CertificateController extends Controller
{ 
    function __construct()
    {
        //  $this->middleware('permission:certificate-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:certificate-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:certificate-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:certificate-delete', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'certificates';
        $page['can'] = 'page';
        $page['title'] = 'Certificate Management';
        return view('webmin.certificates.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Certificate::reorderData($request);
        }
        $getData = Certificate::getData($request);
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
        $page['page'] = 'certificates';
        $page['title'] = 'Certificate Management';
        $page['method'] = 'POST';
        $page['action'] = route('certificates.store');
        return view('webmin.certificates.form',compact('page'));
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
        $store['ref'] =  (Certificate::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Certificate::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Certificate::create($store);
        }

        return redirect()->route('certificates.index')
                        ->with('success','Certificate created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Certificate  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        $page['page'] = 'certificates';
        $page['title'] = 'Certificate Management';
        $page['method'] = 'PUT';
        $page['action'] = route('certificates.update',$certificate->id);
        return view('webmin.certificates.form',compact('certificate','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Certificate  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        request()->validate([
            'title' => 'required',
            'year' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $certificate->update($store);
        return redirect()->route('certificates.index')
                        ->with('success','Certificate updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Certificate  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return redirect()->route('certificates.index')
                        ->with('success','Certificate deleted successfully');
    }
}