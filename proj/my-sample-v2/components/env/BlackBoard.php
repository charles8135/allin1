<?php

/**
 * @file BlackBoard.php
 * @Synopsis  自定义的黑板类，可以作为全局变量存储
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-30
 */

namespace app\components\env;

use app\components\env;

/**
 * 记录一些和环境相关的一次性初始化信息 
 */

class BlackBoard {

    protected $_reqInfo = array();

    protected $_appInfo = array();

    public function initReqInfo() {
        $reqId = env\Util::getReqId();        
        $this->_reqInfo['reqId'] = $reqId;
    }

    public function getReqInfo($key, $defaultValue = null) {
        if (isset($this->_reqInfo[$key])) {
            return $this->_reqInfo[$key];
        } else {
            return $defaultValue;
        }
    }

    public function setReqInfo($key, $value) {
        $this->_reqInfo[$key] = $value;
    }

}
