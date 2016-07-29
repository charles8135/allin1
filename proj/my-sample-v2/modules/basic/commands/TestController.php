<?php

namespace app\modules\basic\commands;

use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex() {
        $e = new \app\components\env\BizException('xxxx');
        $e->logEx();
        var_dump(111);
    }

    public function actionRedis() {
        $redis = new \Redis();
        var_dump($redis);
    }

}
