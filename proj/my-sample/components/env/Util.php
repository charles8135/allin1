<?php

namespace app\components\env;

/**
 * 一些和项目运行环境相关的函数的封装 
 */

class Util {

    public static function getReqId() {
        return intval(microtime(true) * 1000000) . mt_rand(0, 999);    
    }
}
