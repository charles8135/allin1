<?php

namespace app\modules\basic;

use app\components\smarty;

class BaseModule extends \yii\base\Module {

    public function init() {
        parent::init();
    }

    protected function _initSmarty() {
        global $g_config;
        $smartyConfig = $g_config['params']['modules'][$this->id]['smarty'];
        \Yii::$app->smarty->init($smartyConfig);
    }

    protected function _initMisc() {
        \Yii::$app->bb->setReqInfo('curModule', $this->id);
    }

}
