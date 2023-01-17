<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kalender;
use stdClass;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }
 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page['page'] = 'dashboard';
        $page['title'] = 'Dashboard';

        $startDate = Carbon::now(); //returns current day
        $request = new stdClass;
        $request->start_date = $startDate->firstOfMonth();
        $request->end_date = $startDate->lastOfMonth();

        return view('webmin.dashboard.index',compact('page'));
    }
}
