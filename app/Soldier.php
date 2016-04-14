<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Faker\Factory as Faker;


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
     * @return Soldier
     */
    public static function generateRandomSoldier($userID)
    {
        $faker = Faker::create();
        $soldier = new Soldier;
        $soldier->setAttribute('name', $faker->name);
        $soldier->setAttribute('influence_per_minute', rand(1, 5));
        $soldier->setAttribute('user_id',$userID);
        return $soldier;
    }
    
}
