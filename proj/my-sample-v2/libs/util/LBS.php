<?php

/**
 * @file LBS.php
 * @Synopsis  百度LBS API封装类
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-30
 */

namespace app\libs\util;

class LBS {

    protected $_ak = '';

    public function __construct($ak) {
        $this->_ak = $ak;
    }

    public function getGeo($addr) {
        $api = "http://api.map.baidu.com/geocoder/v2/?"
            . "address=%s&output=json&ak=%s";
        $api = sprintf($api, urlencode($addr), $this->_ak);
        $res = file_get_contents($api);
        if (empty($res)) {
            $key = 'LBS_GET_GEO_ERR';
            $msg = "[api: $api]";
            \Yii::error($msg, $key);
            $res = false;
        } else {
            $res = json_decode($res, true);
            $status = $res['status'];

            $key = 'LBS_GET_GEO';
            $msg = "[api: $api][status: $status]";

            if ($status == 1) {
                $msg .= "[msg: {$res['msg']}]";
                \Yii::info($msg, $key);
                $res = false;
            } else {
                $res = $res['result'];    
                \Yii::info($msg, $key);
            }
            return $res;
        }
    }
    
}
