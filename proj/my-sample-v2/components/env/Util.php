<?php

namespace app\components\env;

/**
 * @file Util.php
 * @Synopsis 一些和项目运行环境相关的函数的封装 
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2015-03-16
 */

class Util {

    public static function getReqId() {
        return intval(microtime(true) * 1000000) . mt_rand(100, 999);    
    }

    public static function logEx($e) {
        $stack = str_replace("\n", "\t", $e->getTraceAsString());
        $key = "LOG_EX_STACK";
        \Yii::warning($stack, $key);
    }
}
