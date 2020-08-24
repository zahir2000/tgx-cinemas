<?php

/**
 * Validation class which validates various types of inputs
 *
 * @author Jaloliddin
 */
class Validation {

    static function isEmpty($array, $method = false) {
        if ($method === false) {
            $method = $_REQUEST;
        }
        foreach ($array as $value) {
            if (empty($method[$value])) {
                return false;
            }
        }
        return true;
    }

    static function isInteger($val) {
        return $val = filter_var($val, FILTER_VALIDATE_INT);
    }

    //removes all tags/special characters from a string
    static function cleanString($val) {
        return $val = filter_var($val, FILTER_SANITIZE_STRING);
    }

    static function isBool($val) {
        return $val = filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    static function isEmail($val) {
        return $val = filter_var($val, FILTER_VALIDATE_EMAIL);
    }

    static function isUrl($val) {
        return $val = filter_var($val, FILTER_VALIDATE_URL);
    }

    static function isDate($date) {
        $array = explode('/', $date);
        if (count($array) == 3) {
            if (checkdate($array[0], $array[1], $array[2])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static function isCreditCardValid($number) {
        $regexPattern = "^4[0-9]{12}(?:[0-9]{3})?$";
        if (preg_match($regexPattern, $number)) {
            return true;
        } else {
            return false;
        }
    }

}
