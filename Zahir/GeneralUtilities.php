<?php
/**
 * Description of generalUtilities
 *
 * @author Zahir
 */
final class GeneralUtilities {

    public static function getInHourMinuteFormat($showTime): String {
        $hours = (int) ($showTime / 60);
        $minutes = str_pad($showTime % 60, 2, '0', STR_PAD_RIGHT);
        return $hours . ":" . $minutes;
    }

}
