<?php

namespace app\modules\basic\controllers;

use app\components\yii\Controller;
use app\libs\util;
use app\libs\util\Profiler;
use app\modules\basic\models;
use app\modules\basic\logics;


class IndexController extends Controller {

    /*
    protected function _filters() {
        return [
            [
                'class' => 'app\modules\basic\logics\filters\EnterEchoFilter',
            ],
        ];
    }
    */

    public function actionRoom() {
        echo "SELECT * FROM `room_info` WHERE `room_nianxian` LIKE '满五年' AND `room_weiyi` LIKE '唯一住宅' and
            `room_mianji` >85 and`room_nianling` >2000 ORDER BY `room_info`.`room_guanzhu` DESC";
    }

    public function actionEcho() {
        Profiler::begin(__METHOD__);
        sleep(1);
        $key = 'TEST_KEY';
        $msg = 'INFO balabala';
        \Yii::info($msg, $key);
        \Yii::warning('xxxxxxxxxxxxxxxxx', 'SOMETHING_WARNING');
        \Yii::error('xxxxxxxxxxxxxxxxx', 'SOMETHING_ERROR');
        var_dump('echo');
        Profiler::end(__METHOD__);
        Profiler::log(__METHOD__);
    }

    public function actionRedirect() {
        return $this->redirect('http://www.baidu.com', 301);
    }

    public function actionResp() {
        \Yii::$app->response->content = '<h1>hello world!</h1>';
    }

    // http://domain/basic/index/resp-json
    public function actionRespJson() {
        $this->renderJson(['message' => 'hello world']);
    }

    //NOTICE render模板名如果有/, 则表示从views跟目录下查找
    //       basic/views/root-demo.tpl
    public function actionSmarty() {
        $data = [
            'test_value' => 'liuyue test',
        ];
        $this->render('/root-demo.tpl', $data);
        \Yii::info("liuyue test");
    }

    //NOTICE render模板名如果没有/, 则表示从views/{$controller}/目录下查找
    //       basic/views/index/demo.tpl
    public function actionSmarty2() {
        $data = [
            'test_value' => 'liuyue test',
        ];
        $this->render('demo.tpl', $data);
    }

    public function actionDb() {
        $db = \Yii::$app->db;
        $result = $db->createCommand("select * from room_info")->queryAll();
        var_dump($result);
    }

}
