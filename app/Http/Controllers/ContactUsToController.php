<?php


namespace App\Http\Controllers;

use App\ContactUsTo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ContactUsToController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:contact-us-to-list', ['only' => ['index','show']]);
         $this->middleware('permission:contact-us-to-create', ['only' => ['create','store']]);
         $this->middleware('permission:contact-us-to-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:contact-us-to-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'contact-us-to';
        $page['can'] = 'contact-us-to';
        $page['title'] = 'Contact Us Email Management';
        return view('webmin.contact-us-to.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            ContactUsTo::reorderData($request);
        }
        $getData = ContactUsTo::getData($request);
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
        $page['page'] = 'contact-us-to';
        $page['title'] = 'Contact Us Email Management';
        $page['method'] = 'POST';
        $page['action'] = route('contact-us-to.store');
        return view('webmin.contact-us-to.form',compact('page'));
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
            'email' => 'required',
        ]);
        $store  = $request->all();
        $max_ref = ContactUsTo::max('ref');
        $store['ref'] =  ($max_ref ? $max_ref : 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = ContactUsTo::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder ? $reorder : 0) + 1;
            ContactUsTo::create($store);
        }

        return redirect()->route('contact-us-to.index')
                        ->with('success','Contact Us Email created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContactUsTo  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUsTo $contact_us_to)
    {
        $page['page'] = 'contact-us-to';
        $page['title'] = 'Contact Us Email Management';
        $page['method'] = 'PUT';
        $page['action'] = route('contact-us-to.update',$contact_us_to->id);
        return view('webmin.contact-us-to.form',compact('contact_us_to','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUsTo $contact_us_to)
    {
        request()->validate([
            'title' => 'required',
            'email' => 'required',
        ]);

        $store  = $request->all();
        $contact_us_to->update($store);
        return redirect()->route('contact-us-to.index')
                        ->with('success','Contact Us Email updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUsTo $contact_us_to)
    {
        $contact_us_to->delete();
        return redirect()->route('contact-us-to.index')
                        ->with('success','Contact Us Email deleted successfully');
    }
}
