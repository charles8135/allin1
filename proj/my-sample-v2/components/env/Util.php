<?php

namespace app\components\env;

/**
 * @file Util.php
 * @Synopsis 一些和项目运行环境相关的函数的封装 
 * @author liuyue01@baidu.com
 * @version 1.0.0
 * @date 2015-03-16
 */

class Util {

    public static function getReqId() {
        return intval(microtime(true) * 1000000) . mt_rand(100, 999);    
    }
}
