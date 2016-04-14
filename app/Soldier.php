<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\SoldierFactory;

/**
 * App\Soldier
 *
 * @property-read \App\User $user
 * @mixin \Eloquent
 */
class Soldier extends Model
{
    protected $fillable = [
        'name', 'influence_per_minute', 'user_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Generates a random soldier.
     * @param $userID the ID of the authenticated user.
     * @return Soldier
     */
    public static function generateRandomSoldier($userID)
    {
        return SoldierFactory::produceSoldier('picciotto',$userID);
    }
    
}
