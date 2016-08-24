<?php

namespace app\modules\basic\commands;

use yii\console\Controller;
use app\modules\basic\logics;
use app\modules\basic\models;

class RoomController extends Controller {

    //NOTICE php yii basic/room/crab-list
    public function actionCrabList() {
        $listUrls = logics\room\Config::$START_LIST;

        $listHandler = new logics\room\ListHandler($listUrls);
        $listHandler->handle();
        $roomUrlList = $listHandler->getRes();

        $roomInfoHandler = new logics\room\InfoHandler($roomUrlList);
        $roomInfoHandler->handle();

        //NOTICE 针对失败的情况，重试一次
        $key = 'ROOM_HANLDE_RETRY';
        $msg = 'Retry Begin';
        \Yii::info($msg, $key);

        $failList = $roomInfoHandler->getFailList();
        $roomInfoHandler = new logics\room\InfoHandler($failList);
        $roomInfoHandler->handle();

        $msg = 'Retry End';
        \Yii::info($msg, $key);

    }

    public function actionTest() {
        $ids = file('/home/liuyue01/var/room/bin/retry');
        $ids = array_map('trim', $ids);
        $ids = array(101091969814);
        
        foreach($ids as $id) {
            $list[] = "http://bj.lianjia.com/ershoufang/$id.html";
        }
        $infoObj = new logics\room\InfoHandler($list);
        $infoObj->handle();
    }

    public function actionStat() {
        $handler = new logics\room\ChooseHandler();
        $handler->someStat();
    } 

    public function actionUpdateDistance() {
        $handler = new logics\room\ChooseHandler();
        $handler->updateDistance();
    }

}
