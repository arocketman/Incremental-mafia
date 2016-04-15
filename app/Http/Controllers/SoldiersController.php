<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Soldier;


use App\Http\Requests;

class SoldiersController extends Controller
{
    /**
     * Generates a soldier with given stats.
     * @return The soldiers list.
     */
    public function newSoldier(){
        if (Auth::user()->influence < 5) {
            return (Auth::user()->soldiers);
            //flash no IP.
        }
        Auth::user()->decreaseIP(25);
        $soldier = Soldier::generateRandomSoldier(Auth::user()->id);
        Auth::user()->soldiers()->create($soldier->toArray());
        return (Auth::user()->soldiers);
    }

    public function deleteSoldier($soldierID){
        $soldier = Soldier::find($soldierID);
        if($soldier != null && $soldier->user_id == Auth::user()->id){
            $soldier->delete();
        }
        return $this->getSoldiersList();
    }

    public function getSoldiersList()
    {
        return response()->json(Auth::user()->soldiers->sortByDesc('influence_per_minute'));
    }


}
