<?php

namespace app\modules\basic\commands;

use yii\console\Controller;
use app\modules\basic\logics;
use app\modules\basic\models;

class RoomController extends Controller {

    //NOTICE php yii basic/room/crab-list
    public function actionCrabList() {
        $listUrls = logics\room\Config::$START_LIST;

        $listObj = new logics\room\ListHandler($listUrls);
        $listObj->handle();
        $roomUrlList = $listObj->getRes();

        $infoObj = new logics\room\InfoHandler($roomUrlList);
        $infoObj->handle();

    }

    public function actionTest() {
        $room = models\RoomInfo::findOne(4);
        var_dump($room);
    }

}
