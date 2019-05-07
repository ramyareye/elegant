<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 4/23/2016
 * Time: 3:39 PM
 */

namespace App\Http\Controllers;

use jDateTime;

class Utility {

    /*
     * @param int day
     * @return String
     */
    public static $sqlDataSeparator = ';;;;;';

    public static function increaseDayToJalaliDate($day, $numOfDay) {
        $day_array = explode('/', $day);
        $day_timestamp = jDateTime::mktime(0, 0, 0,
            $day_array[1], $day_array[2], $day_array[0], true, 'Asia/Tehran');
        $numOfDay = '+' . $numOfDay . 'day';
        $increaseDay = strtotime($numOfDay, $day_timestamp);
        $resultDate = date('Y-m-d', $increaseDay);
        $resultDate_array = explode('-', $resultDate);
        $resultDateToJalali = jDateTime::toJalali($resultDate_array[0], $resultDate_array[1], $resultDate_array[2]);
        $result = implode("/", $resultDateToJalali);

        return $result;

    }

    public static function convertPersianDigitToEnglishDigit($string) {
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
        $num = range(0, 9);

        return str_replace($persian, $num, $string);
    }

    public static function createJalaliDate($date) {
        $dateTime = date_create_from_format('Y-m-d H:i:s', $date);
        $jdate = jDateTime::toJalali($dateTime->format('Y'), $dateTime->format('m'), $dateTime->format('d'));
        $jalaliDate = $jdate[0] . '-' . $jdate[1] . '-' . $jdate[2] . ' ' . $dateTime->format('H:i:s');

        return $jalaliDate;
    }
}