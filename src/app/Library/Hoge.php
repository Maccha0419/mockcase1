<?php

namespace App\Library;

use Illuminate\Support\Facades\Facade;

class Hoge extends Facade
{
    public function Time ()
    {
        $hours = floor($diffInSeconds / 3600);//小数点切り捨て
        $minutes = floor(($diffInSeconds % 3600) / 60);
        $seconds = $diffInSeconds % 60;
        $time = $hours.":".$minutes.":".$seconds;
        return $time;
    }
}