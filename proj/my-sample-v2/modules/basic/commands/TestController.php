<?php

namespace app\modules\basic\commands;

use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex() {
        echo "hello world from " . __METHOD__ . "\n";    
    }

}
