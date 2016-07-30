<?php

namespace app\modules\basic\commands;

use yii\console\Controller;
use app\libs\util;

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

    public function actionTest() {
        $ak = \Yii::$app->params['baidu-lbs-key'];
        $lbs = new util\LBS($ak);
        $res = $lbs->getGeo("北京市朝阳万象新天四区");
        var_dump($res);
    }

}
