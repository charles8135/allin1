<?php

namespace app\components\filters;

use yii\base\ActionFilter;
use app\libs\util\Profiler;

class ActionTimerFilter extends ActionFilter {

    protected function _getKey($action) {
        $moduleId = $action->controller->module->id;
        $controllerId = $action->controller->id;
        $actionId = $action->id;
        $key = "##Action Profiler##$"  
            . "{$moduleId}_{$controllerId}_{$actionId}";
        return $key;
    }

    public function beforeAction($action) {
        $key = $this->_getKey($action);
        Profiler::begin($key);

        return true;
    }

    public function afterAction($action, $result) {
        $key = $this->_getKey($action);
        Profiler::end($key);
        $timeCost = Profiler::time($key);
        Profiler::free($key);
        list($prefix, $actionInfo) = explode("$", $key);
        $logKey = "Action Time Cost";
        $logMsg = "[action:{$actionInfo}][time(ms):{$timeCost}]";
        \Yii::info($logMsg, $logKey);

        return $result;
    }


}
