<?php


namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ContactUsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:contact-us-list', ['only' => ['index','show']]);
         $this->middleware('permission:contact-us-edit', ['only' => ['edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $page['page'] = 'contact-us';
        $page['can'] = 'contact-us';
        $page['title'] = 'Contact Us Management';
        return view('webmin.contact-us.index',compact('page'));
    }
    public function json(Request $request){
        $getData = ContactUs::getData($request);
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContactUs  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactUs $contact_us)
    {
        $page['page'] = 'contact-us';
        $page['title'] = 'Contact Us Management';
        $page['method'] = 'PUT';
        $page['action'] = route('contact-us.update',$contact_us->id);
        return view('webmin.contact-us.form',compact('contact_us','page'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactUs $contact_us)
    {
        request()->validate([
            'title' => 'required',
            'email' => 'required',
        ]);

        $store  = $request->all();
        $contact_us->update($store);
        return redirect()->route('contact-us.index')
                        ->with('success','Contact Us updated successfully');
    }
}
