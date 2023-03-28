<?php

namespace App\Http\Controllers;

use App\AnnualReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnnualController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:annual-list', ['only' => ['index','store']]);
        //  $this->middleware('permission:annual-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:annual-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:annual-delete', ['only' => ['destroy']]);
    }


    public function json(Request $request){
        if ($request->reorder){
            AnnualReport::reorderData($request);
        }
        $getData = AnnualReport::getData($request);
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
        $page['page'] = 'annual-report';
        $page['can'] = 'page';
        $page['title'] = 'Annual Report Management';
        return view('webmin.annual-report.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'annual-report';
        $page['title'] = 'Annual Report Management';
        $page['method'] = 'POST';
        $page['action'] = route('annual-report.store');
        return view('webmin.annual-report.form',compact('page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);
        $store['ref'] =  (AnnualReport::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = AnnualReport::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            AnnualReport::create($store);
        }

        return redirect()->route('annual-report.index')
                        ->with('success','Annual report created successfully.');
    }

    public function edit(AnnualReport $ebook)
    {
        $page['page'] = 'annual-report';
        $page['title'] = 'Annual Report Management';
        $page['method'] = 'PUT';
        $page['action'] = route('annual-report.update',$ebook->id);
        return view('webmin.annual-report.form',compact('page','ebook'));
    }
    public function update(Request $request, AnnualReport $ebook)
    {
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $ebook->update($store);
        return redirect()->route('annual-report.index')
                        ->with('success','Annual report updated successfully');
    }
    public function destroy(AnnualReport $ebook)
    {
        $ebook->delete();

        return redirect()->route('annual-report.index')
                        ->with('success','Annual report deleted successfully');
    }
}
