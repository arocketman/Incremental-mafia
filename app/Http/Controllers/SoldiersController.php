<?php

namespace App\Http\Controllers;
use App\Libraries\UtilityFunctions;
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
        $soldierPrice = Auth::user()->soldiers->count() * \Config::get('constants.base_soldier_cost');
        //Avoiding soldierPrice equal to 0.
        $soldierPrice = $soldierPrice ?: \Config::get('constants.base_soldier_cost');
        if (Auth::user()->influence < $soldierPrice) {
            return (UtilityFunctions::json_response_error(Auth::user()->soldiers));
        }
        Auth::user()->decreaseIP(25);
        $soldier = Soldier::generateRandomSoldier(Auth::user()->id);
        Auth::user()->soldiers()->create($soldier->toArray());
        return (UtilityFunctions::json_response_ok(Auth::user()->soldiers));
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
