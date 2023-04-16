<?php


namespace App\Http\Controllers;

use App\NewsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;


class NewsCategoryController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:news-category-list', ['only' => ['index','show']]);
         $this->middleware('permission:news-category-create', ['only' => ['create','store']]);
         $this->middleware('permission:news-category-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:news-category-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'news-category';
        $page['can'] = 'news-category';
        $page['title'] = 'News Category Management';
        return view('webmin.news-category.index',compact('page'));
    }
    public function json(Request $request){
        $getData = NewsCategories::getData($request);
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
        $page['page'] = 'news-category';
        $page['title'] = 'News Category Management';
        $page['method'] = 'POST';
        $page['action'] = route('news-category.store');
        return view('webmin.news-category.form',compact('page'));
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
        ]);
        $store  = $request->all();
        $alias = str_slug($request->title, '-');
        $store['alias'] =  $alias;
        $max_ref = NewsCategories::max('ref');
        $store['ref'] =  ($max_ref ? $max_ref : 0) + 1;
        foreach (config('app.locales') as $lang) {
            $store['lang'] =  $lang;
            NewsCategories::create($store);
        }

        return redirect()->route('news-category.index')
                        ->with('success','News Category created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NewsCategories  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsCategories $news_category)
    {
        $page['page'] = 'news-category';
        $page['title'] = 'News Category Management';
        $page['method'] = 'PUT';
        $page['action'] = route('news-category.update',$news_category->id);
        return view('webmin.news-category.form',compact('news_category','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NewsCategories  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsCategories $news_category)
    {
        request()->validate([
            'title' => 'required',
        ]);

        $store  = $request->all();
        $news_category->update($store);
        return redirect()->route('news-category.index')
                        ->with('success','News Category updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NewsCategories  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsCategories $news_category)
    {
        $news_category->delete();
        return redirect()->route('news-category.index')
                        ->with('success','News Category deleted successfully');
    }
}
