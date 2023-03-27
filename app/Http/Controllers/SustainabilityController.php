<?php

namespace App\Http\Controllers;

use App\Ebook;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SustainabilityController extends Controller
{
    function __construct()
    {
        //  $this->middleware('permission:news-list', ['only' => ['index','store']]);
        //  $this->middleware('permission:news-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:news-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }


    public function json(){
        return DataTables::of(Ebook::where('type', '=', 'sustainability')->orderBy('id','DESC'))->addIndexColumn()->make(true);
    }

    public function index(Request $request)
    {
        $page['page'] = 'sustainability-report';
        $page['can'] = 'page';
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
        $store['ref'] =  (Ebook::where('type', '=', 'sustainability')->max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Ebook::where('type', '=', 'sustainability')->where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Ebook::create($store);
        }

        return redirect()->route('sustainability-report.index')
                        ->with('success','Sustainability report created successfully.');
    }

    public function edit(Ebook $ebook)
    {
        $page['page'] = 'sustainability-report';
        $page['title'] = 'Sustainability Report Management';
        $page['method'] = 'PUT';
        $page['action'] = route('sustainability-report.update',$ebook->id);
        return view('webmin.sustainability-report.form',compact('page','ebook'));
    }
    public function update(Request $request, Ebook $ebook)
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
    public function destroy(Ebook $ebook)
    {
        $ebook->delete();

        return redirect()->route('sustainability-report.index')
                        ->with('success','Sustainability report deleted successfully');
    }
}
