<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Soldier;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
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

    public function family($request)
    {
        if(Auth::user()->id == $request)
            return view('family\family');
        return view('home');
    }

    public function newSoldier(){
        $soldier = Soldier::generateRandomSoldier(Auth::user()->id);
        Auth::user()->soldiers()->create($soldier->toArray());
        return $this->family(Auth::user()->id);
    }

    public function updateIP(){
        return Auth::user()->updateIP();
    }
    
}
