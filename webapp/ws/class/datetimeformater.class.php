<?php


/**
* 
*/
class DateTimeFormater {

    public static function formatDate($date){
        //$date = DateTime::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d')." 00:00:00");
        $now = new DateTime();
        $now = DateTime::createFromFormat('Y-m-d H:i:s', $now->format('Y-m-d')." 00:00:00");
        $diffInterval = $date->diff($now);

        if($diffInterval->format('%a') == 0)
            return "Heute";
        if($diffInterval->format('%a') == 1)
            return "Morgen";

        $weekDay = $date->format('w');
        switch ($weekDay) {
            case '0':
                $weekDay = "Sonntag";
                break;
            case '1':
                $weekDay = "Montag";
                break;
            case '2':
                $weekDay = "Dienstag";
                break;
            case '3':
                $weekDay = "Mitwoch";
                break;
            case '4':
                $weekDay = "Donnerstag";
                break;
            case '5':
                $weekDay = "Freitag";
                break;
            case '6':
                $weekDay = "Samstag";
                break;
            
            default:
                # code...
                break;
        }

        $day = $date->format('j');
        $month = $date->format('n');

        $result = $weekDay.", ".$day.".".$month;
        return $result;
    }

}