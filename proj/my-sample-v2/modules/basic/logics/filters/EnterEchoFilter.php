<?php

namespace app\modules\basic\logics\filters;

use yii\base\ActionFilter;

class EnterEchoFilter extends ActionFilter {

    public function beforeAction($action) {
        echo __METHOD__ . "<br>";
        return true;
    }
}
