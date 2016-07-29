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

    public function actionRedo() {
        $list = array(
            'http://bj.lianjia.com/ershoufang/101100322502.html',
        );
        $infoObj = new logics\room\InfoHandler($list);
        $infoObj->handle();
    }

}
