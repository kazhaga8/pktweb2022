<?php


namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ProductController extends Controller
{
    public $product_options;
    function __construct()
    {
         $this->middleware('permission:product-list', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        $product_options = [
            ["id" => "urea", "name" => "Urea"],
            ["id" => "amoniak", "name" => "Amoniak"],
            ["id" => "npk", "name" => "NPK"],
            ["id" => "hayati", "name" => "Pupuk Hayati"]
        ];
        $this->product_options = json_decode(json_encode($product_options));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'products';
        $page['can'] = 'product';
        $page['title'] = 'Product Management';
        return view('webmin.products.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Product::reorderData($request);
        }
        $getData = Product::getData($request);
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
        $page['page'] = 'products';
        $page['title'] = 'Product Management';
        $page['method'] = 'POST';
        $page['action'] = route('products.store');
        $product_options = $this->product_options;
        return view('webmin.products.form',compact('page', 'product_options'));
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
            'product' => 'required',
            'variant' => 'required',
            'image' => 'required',
        ]);
        $store  = $request->all();
        $store['ref'] =  (Product::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Product::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Product::create($store);
        }

        return redirect()->route('products.index')
                        ->with('success','Product created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $page['page'] = 'products';
        $page['title'] = 'Product Management';
        $page['method'] = 'PUT';
        $page['action'] = route('products.update',$product->id);
        $product_options = $this->product_options;
        return view('webmin.products.form',compact('product','page', 'product_options'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        request()->validate([
            'product' => 'required',
            'variant' => 'required',
        ]);

        $store  = $request->all();
        $product->update($store);
        return redirect()->route('products.index')
                        ->with('success','Product updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
                        ->with('success','Product deleted successfully');
    }
}
