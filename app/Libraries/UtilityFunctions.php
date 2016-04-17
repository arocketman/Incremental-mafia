<?php

namespace App\Libraries;

class UtilityFunctions
{
    public static function float_rand($Min, $Max, $round = 2)
    {
        //validate input
        if ($Min > $Max) {
            $min = $Max;
            $max = $Min;
        } else {
            $min = $Min;
            $max = $Max;
        }
        $randomfloat = $min + mt_rand() / mt_getrandmax() * ($max - $min);
        if ($round > 0)
            $randomfloat = round($randomfloat, $round);

        return $randomfloat;
    }

    public static function json_response_ok($data = null){
        return response()->json(['response'=>'OK','data'=>$data]);
    }

    public static function json_response_error($data = null){
        return response()->json(['response'=>'ERROR','data'=>$data]);
    }
}