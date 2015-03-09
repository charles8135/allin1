<?php

namespace app\modules\monitor\controllers;

use yii\web\Controller;
use app\libs\Util;
use app\modules\monitor\services;

class IndexController extends Controller {

    public function actionEcho () {
        var_dump(__CLASS__);
        var_dump(__METHOD__);
        Util\String::myEcho("hello world");
        services\Demo::echoService("hello services");
        var_dump($_GET);
    }
}
