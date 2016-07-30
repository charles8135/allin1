<?php

/**
 * @file ChooseHandler.php
 * @Synopsis 房屋判断选择类
 * @author liuyue01@baidu.com
 * @version 1.0.0
 * @date 2016-07-29
 */

namespace app\modules\basic\logics\room;

use app\components\env;
use app\modules\basic\models;

class ChooseHandler {

    public function handle() {
        var_dump(111);
    }

    public function priceStat() {
        $rooms = models\RoomInfo::find()
            ->where(['status' => 0])->all();
        foreach($rooms as $room) {
            $xiaoqu = $room->room_xiaoqu;
            $prices = $prices1 = json_decode($room->room_lishijiage, true);    
            $first = array_shift($prices);
            $last = array_pop($prices1);
            if ($first == $last) {
                $xiaoquPriceRes[$xiaoqu]['same']++;
            } else if ($first < $last) {
                $xiaoquPriceRes[$xiaoqu]['up']++;
            } else {
                $xiaoquPriceRes[$xiaoqu]['down']++;
            }
        }

        //NOTICE output res
        echo "xiaoqu, up, same, down, sum\n";
        foreach($xiaoquPriceRes as $xq => $one) {
            $sum = array_sum($one);
            $up = round($one['up']/$sum, 3);
            $down = round($one['down']/$sum, 3);
            $same = round($one['same']/$sum, 3);

            echo iconv('UTF-8', 'GBK', "$xq, $up, $same, $down, $sum\n");
        }
        echo "[done]\n";
    }

    protected function _getAll() {
        $rooms = models\RoomInfo::findAll();
        var_dump();
    }



}
