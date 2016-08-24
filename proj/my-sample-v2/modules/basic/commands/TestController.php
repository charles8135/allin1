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
        $sn = \Yii::$app->params['baidu-lbs-sn'];
        $lbs = new util\LBS($ak, $sn);
        $res = $lbs->getDirection("北京市海淀区信息学院家属楼",
                "北京市海淀区西北旺百度科技园1号楼");
        var_dump($res);
    }

}
