<?php

namespace App\Http\Controllers;

use App\SustainabilityReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SustainabilityController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:sustainability-report-list', ['only' => ['index','store']]);
         $this->middleware('permission:sustainability-report-create', ['only' => ['create','store']]);
         $this->middleware('permission:sustainability-report-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:sustainability-report-delete', ['only' => ['destroy']]);
    }


    public function json(Request $request){
        if ($request->reorder){
            SustainabilityReport::reorderData($request);
        }
        $getData = SustainabilityReport::getData($request);
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

    public function index(Request $request)
    {
        $page['page'] = 'sustainability-report';
        $page['can'] = 'sustainability-report';
        $page['title'] = 'Sustainability Report Management';
        return view('webmin.sustainability-report.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'sustainability-report';
        $page['title'] = 'Sustainability Report Management';
        $page['method'] = 'POST';
        $page['action'] = route('sustainability-report.store');
        return view('webmin.sustainability-report.form',compact('page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);
        $store['ref'] =  (SustainabilityReport::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = SustainabilityReport::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            SustainabilityReport::create($store);
        }

        return redirect()->route('sustainability-report.index')
                        ->with('success','Sustainability report created successfully.');
    }

    public function edit(SustainabilityReport $ebook)
    {
        $page['page'] = 'sustainability-report';
        $page['title'] = 'Sustainability Report Management';
        $page['method'] = 'PUT';
        $page['action'] = route('sustainability-report.update',$ebook->id);
        return view('webmin.sustainability-report.form',compact('page','ebook'));
    }
    public function update(Request $request, SustainabilityReport $ebook)
    {
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $ebook->update($store);
        return redirect()->route('sustainability-report.index')
                        ->with('success','Sustainability report updated successfully');
    }
    public function destroy(SustainabilityReport $ebook)
    {
        $ebook->delete();

        return redirect()->route('sustainability-report.index')
                        ->with('success','Sustainability report deleted successfully');
    }
}
