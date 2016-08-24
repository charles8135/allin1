<?php

/**
 * @file Util.php
 * @Synopsis 房屋处理逻辑通用工具函数
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-21
 */


namespace app\modules\basic\logics\room;

class Util {

    public static function extraInfo($reg, $str, $logErr = true) {
        $res = @preg_match($reg, $str, $matches);
        if ($res != 1) {
            if ($logErr) {
                $key = 'EXTRA_INFO_ERR';
                $msg = "[reg: $reg]";
                \Yii::error($msg, $key);    
            }
            return false;
        } else {
            return $matches;
        }
    }

}
