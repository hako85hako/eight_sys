<?php
namespace App\MyTools;
class dateControllTools{
    public function get_dayOfWeek($num){
        switch ($num) {
            case 1:
                $dayOfWeek = "月";
                break;

            case 2:
                $dayOfWeek = "火";
                break;
            
            case 3:
                $dayOfWeek = "水";
                break;

            case 4:
                $dayOfWeek = "木";
                break;
            
            case 5:
                $dayOfWeek = "金";
                break;

            case 6:
                $dayOfWeek = "土";
                break;
            
            case 7:
                $dayOfWeek = "日";
                break;
        }
        return $dayOfWeek;
    }
}