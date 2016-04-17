<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Libraries\UtilityFunctions;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Redirects to the family page if hte user is logged in and attempts to access its own family page.
     * @param $request
     * @return mixed
     */
    public function family($request)
    {
        if(Auth::user()->id == $request)
            return view('family/family');
        return view('home');
    }
    
    /**
     * Asks the server for an influence point update and returns the new value.
     * @return json
     */
    public function updateIP(){
        return response()->json(['totalIP' => Auth::user()->updateIP() , 'incrementPS' => Auth::user()->getTotalInfluencePerSecond()]);
    }

    public function redeemBonusIP(){
        if(!Auth::user()->bonusIpRedeemed()){
            Auth::user()->influence += 100;
            Auth::user()->bonusIpRedeemDate = Carbon::now();
            Auth::user()->save();
            return UtilityFunctions::json_response_ok();
        }
        return UtilityFunctions::json_response_error();
    }



}
