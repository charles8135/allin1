<?php

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
