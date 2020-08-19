<?php

require_once 'DayTime.php';

/**
 * Description of GeneralUtilities
 *
 * @author Zahir
 */
final class GeneralUtilities {

    public static function getInHourMinuteFormat($showTime): String {
        $hours = (int) ($showTime / 60);
        $minutes = str_pad($showTime % 60, 2, '0', STR_PAD_RIGHT);
        return $hours . ":" . $minutes;
    }

    public static function getTimeInInt($time) {
        return intval(60 * substr($time, 0, 2)) + intval(substr($time, 3));
    }

    public static function getTimeOfDay($time) {
        /*
         * Morning: 00:00 - 11:59
         * Afternoon: 12:00 - 17:59
         * Evening: 18:00 - 23:59
         */

        $timeInInt = self::getTimeInInt($time);
        
        if ($timeInInt >= 0 && $timeInInt <= 719) {
            return DayTime::MORNING;
        }
        else if ($timeInInt >= 720 && $timeInInt <= 1079){
            return DayTime::AFTERNOON;
        }
        else if ($timeInInt >= 1080 && $timeInInt <= 1439){
            return DayTime::EVENING;
        }
        
        return null;
    }

}
