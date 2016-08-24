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
    protected $_sn = '';

    public function __construct($ak, $sn) {
        $this->_ak = $ak;
        $this->_sn = $sn;
    }

    public function getGeo($addr) {
        $api = "http://api.map.baidu.com/geocoder/v2/?"
            . "address=%s&output=json&ak=%s&sn=%s&timestamp=%s";
        $api = sprintf($api, urlencode($addr), $this->_ak, $this->_sn, time());
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

    public function getDirection($addrA, $addrB, $regA = '北京', $regB = '北京') {
        $api = 'http://api.map.baidu.com/direction/v1?'
            . 'mode=driving&origin=%s&destination=%s'
            . '&origin_region=%s&destination_region=%s&output=json&ak=%s&sn=%s&timestamp=%s';
        $api = sprintf($api, 
                urlencode($addrA), urlencode($addrB),
                urlencode($regA), urlencode($regB), 
                $this->_ak, $this->_sn, time()
        );
        $res = file_get_contents($api);
        var_dump($res);
        if (empty($res)) {
            $key = 'LBS_GET_DIRECTION_ERR';
            $msg = "[api: $api]";
            \Yii::error($msg, $key);
            $res = false;
        } else {
            $res = json_decode($res, true);
            $status = $res['status'];
            $type = $res['type'];

            $key = 'LBS_GET_DIRECTION';
            $msg = "[api: $api][status: $status][type: $type]";

            if ($status == 1 || $type == 1) {
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
