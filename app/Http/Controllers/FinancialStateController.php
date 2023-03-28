<?php

namespace App\Http\Controllers;

use App\FinancialReport;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinancialStateController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:financial-list', ['only' => ['index','store']]);
        //  $this->middleware('permission:financial-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:financial-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:financial-delete', ['only' => ['destroy']]);
    }

    public function json(Request $request){
        if ($request->reorder){
            FinancialReport::reorderData($request);
        }
        $getData = FinancialReport::getData($request);
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
        $page['page'] = 'financial-statements';
        $page['can'] = 'page';
        $page['title'] = 'Financial Statements Management';
        return view('webmin.financial-statements.index',compact('page'));
    }

    public function create()
    {
        $page['page'] = 'financial-statements';
        $page['title'] = 'Financial Statements Management';
        $page['method'] = 'POST';
        $page['action'] = route('financial-statements.store');
        return view('webmin.financial-statements.form',compact('page'));
    }

    public function store(Request $request)
    {
        $store  = $request->all();
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);
        $store['ref'] =  (FinancialReport::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = FinancialReport::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            FinancialReport::create($store);
        }

        return redirect()->route('financial-statements.index')
                        ->with('success','Financial statements created successfully.');
    }

    public function edit(FinancialReport $ebook)
    {
        $page['page'] = 'financial-statements';
        $page['title'] = 'Financial Statements Management';
        $page['method'] = 'PUT';
        $page['action'] = route('financial-statements.update',$ebook->id);
        return view('webmin.financial-statements.form',compact('page','ebook'));
    }
    public function update(Request $request, FinancialReport $ebook)
    {
        request()->validate([
            'title' => 'required',
            'file' => 'required',
            'image' => 'required',
        ]);

        $store  = $request->all();
        $ebook->update($store);
        return redirect()->route('financial-statements.index')
                        ->with('success','Financial statements updated successfully');
    }
    public function destroy(FinancialReport $ebook)
    {
        $ebook->delete();

        return redirect()->route('financial-statements.index')
                        ->with('success','Financial statements deleted successfully');
    }
}
