<?php


namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ContactController extends Controller
{ 
    function __construct()
    {
        //  $this->middleware('permission:contact-list', ['only' => ['index','show']]);
        //  $this->middleware('permission:contact-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:contact-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:contact-delete', ['only' => ['destroy']]);
    }
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'contacts';
        $page['can'] = 'page';
        $page['title'] = 'Contact Management';
        return view('webmin.contacts.index',compact('page'));
    }
    public function json(Request $request){
        if ($request->reorder){
            Contact::reorderData($request);
        }
        $getData = Contact::getData($request);
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
        $page['page'] = 'contacts';
        $page['title'] = 'Contact Management';
        $page['method'] = 'POST';
        $page['action'] = route('contacts.store');
        return view('webmin.contacts.form',compact('page'));
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
            'content' => 'required',
            'maps' => 'required',
        ]);
        $store  = $request->all();
        $store['ref'] =  (Contact::max('ref') || 0) + 1;
        foreach (config('app.locales') as $lang) {
            $reorder = Contact::where('lang', '=', $lang)->max('reorder');
            $store['lang'] =  $lang;
            $store['reorder'] =  ($reorder || 0) + 1;
            Contact::create($store);
        }

        return redirect()->route('contacts.index')
                        ->with('success','Contact created successfully.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contact  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $page['page'] = 'contacts';
        $page['title'] = 'Contact Management';
        $page['method'] = 'PUT';
        $page['action'] = route('contacts.update',$contact->id);
        return view('webmin.contacts.form',compact('contact','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contact  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        request()->validate([
            'title' => 'required',
            'content' => 'required',
            'maps' => 'required',
        ]);

        $store  = $request->all();
        $contact->update($store);
        return redirect()->route('contacts.index')
                        ->with('success','Contact updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contact  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')
                        ->with('success','Contact deleted successfully');
    }
}