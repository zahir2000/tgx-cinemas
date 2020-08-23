<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Utility/DayTime.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Classes/Hall.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Utility/GeneralUtilities.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/LuxeDecorator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/RegularDecorator.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/tgx-cinemas/Zahir/Decorator/DeluxeDecorator.php';

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
        } else if ($timeInInt >= 720 && $timeInInt <= 1079) {
            return DayTime::AFTERNOON;
        } else if ($timeInInt >= 1080 && $timeInInt <= 1439) {
            return DayTime::EVENING;
        }

        return null;
    }

    public static function getIntTimeOfDay($time) {
        if ($time >= 0 && $time <= 719) {
            return DayTime::MORNING;
        } else if ($time >= 720 && $time <= 1079) {
            return DayTime::AFTERNOON;
        } else if ($time >= 1080 && $time <= 1439) {
            return DayTime::EVENING;
        }

        return null;
    }

    public static function calculatePrice($result) {
        $resultNew = array();
        
        foreach ($result as $r) {
            $basePrice = $r['basePrice'];
            $time = $r['showTime'];

            $baseHall = new Hall($basePrice);
            $timeOfDay = self::getIntTimeOfDay($time);

            $hallType = explode(',', $r['experience']);

            foreach ($hallType as $h) {
                switch ($h) {
                    case "Deluxe":
                        $baseHall = new DeluxeDecorator($baseHall, $timeOfDay);
                        break;
                    case "LUXE":
                        $baseHall = new LuxeDecorator($baseHall, $timeOfDay);
                        break;
                    case "Regular":
                        $baseHall = new RegularDecorator($baseHall, $timeOfDay);
                        break;
                    default:
                        echo "No Hall Type Found!";
                }
            }

            $r['price'] = $baseHall->cost();
            $resultNew[] = $r;
        }
        
        return $resultNew;
    }

}
