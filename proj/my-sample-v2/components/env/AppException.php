<?php

/**
 * @file AppException.php
 * @Synopsis 自定义异常基类
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-26
 */

namespace app\components\env;

class AppException extends \Exception {

    public function logEx() {
        $stack = str_replace("\n", "\t", $this->getTraceAsString());
        $key = "LOG_EX_STACK";
        \Yii::warning($stack, $key);
    }

}
