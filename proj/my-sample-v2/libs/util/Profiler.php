<?php

namespace app\libs\util;

class Profiler {

    protected static $_profileInfo = array();

    public static function begin($key) {
        if (isset(self::$_profileInfo[$key])) {
            $logKey = "Profile Begin Exist";
            $logMsg = "[key:{$key}]";
            \Yii::info($logMsg, $logKey);
        } else {
            self::$_profileInfo[$key]['begin'] = Timer::millitime();
            self::$_profileInfo[$key]['end'] = 0;
        }
    }

    public static function end($key) {
        if (! isset(self::$_profileInfo[$key])) {
            self::$_profileInfo[$key]['begin'] = 0;

            $logKey = "Profile End Not Exist";
            $logMsg = "[key:{$key}]";
            \Yii::info($logMsg, $logKey);
        }
        self::$_profileInfo[$key]['end'] = Timer::millitime();
    }

    public static function time($key) {
        if (isset(self::$_profileInfo[$key])) {
            return self::$_profileInfo[$key]['end']
                - self::$_profileInfo[$key]['begin'];
        }
    }

    public static function log($key) {
        if (isset(self::$_profileInfo[$key])) {
            $timeCost = self::time($key);
            $logKey = 'ProfilerLog';
            $logMsg = "[key:{$key}][time(ms):{$timeCost}]";
        } else {
            $logKey = 'Profile Key Not Exist';
            $logMsg = "[key:{$key}]";
        }
        \Yii::info($logMsg, $logKey);
    }

    public static function free($key) {
        unset(self::$_profileInfo[$key]);
    }

    public static function freeAll() {
        self::$_profileInfo = array();
    }

}
