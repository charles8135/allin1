<?php

namespace util;

/**
 * @file Misc.php
 * @Synopsis Misc类，一些通用方法放在这里
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2015-03-26
 */

class Misc {

    public static function getReqId() {
        return intval(microtime(true) * 1000000) . mt_rand(100, 999);    
    }

}
