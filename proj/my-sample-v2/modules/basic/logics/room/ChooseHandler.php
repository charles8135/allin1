<?php

/**
 * @file ChooseHandler.php
 * @Synopsis 房屋判断选择类
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-29
 */

namespace app\modules\basic\logics\room;

use app\components\env;
use app\modules\basic\models;
use app\libs\util;

class ChooseHandler {

    public function handle() {
        var_dump(111);
    }

    public function someStat() {
        //NOTICE 新房上架 
        $count = models\RoomInfo::find()
            ->where(
                [   
                    'and',
                    'room_status = 0',
                    "create_time >= '2016-07-26'",
                ]
            )->count();
        echo "2016-07-26 new: $count\n";

        //NOTICE 每周成交 
        $count = models\RoomInfo::find()
            ->where(
                [   
                    'and',
                    'room_status = 1',
                    "create_time >= 2016-07-26",
                ]
            )->count();
        echo "2016-07-26 deal: $count\n";

        //NOTICE 价格分析
        $rooms = models\RoomInfo::find()
            ->where(['room_status' => 0])->all();
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

    public function updateDistance() {
        $xiaoqu = array();
        $workPos = Config::$WORK_POS;
        $rooms = models\RoomInfo::find()
            ->where(['room_status' => 0])->all();
        $ak = \Yii::$app->params['baidu-lbs-key'];
        $sn = \Yii::$app->params['baidu-lbs-sn'];
        $lbs = new util\LBS($ak, $sn);

        foreach($rooms as $room) {
            $dizhi = $room->room_dizhi;
            $juli = $room->room_juli;
            if (! isset($xiaoqu[$dizhi])) {
                if (! empty($juli)) {
                    $xiaoqu[$dizhi]['juli'] = $juli;
                    $xiaoqu[$dizhi]['kaicheshijian'] = $room->room_kaicheshijian;
                } else {
                    $xiaoqu[$dizhi] = [
                        'juli' => 0,
                        'kaicheshijian' => 0,
                    ];
                }
            }
        }

        foreach($xiaoqu as $dizhi => $info) {
            if (! empty($info['juli'])) {
                continue;
            }
            $res = $lbs->getDirection($dizhi, $workPos);
            if ($res === false) {
                unset($xiaoqu[$dizhi]);
                $key = 'GET_ROOM_DISTANCE_FAIL';
                $msg = "[xiaoqu: $dizhi]";
                \Yii::warning($msg, $key);
                continue;
            }
            $xiaoqu[$dizhi]['juli'] = $res['routes'][0]['distance'];
            $xiaoqu[$dizhi]['kaicheshijian'] = $res['routes'][0]['duration'];
        }

        $rooms = models\RoomInfo::find()
             ->where(['room_status' => 0])->all();
        foreach($rooms as $room) {
            $dizhi = $room->room_dizhi;
            $bianhao = $room->room_bianhao;
            if ($room->room_juli != 0 || ! isset($xiaoqu[$dizhi])) {
                continue;
            }
            $juli = $xiaoqu[$dizhi]['juli'];
            $kaicheshijian = $xiaoqu[$dizhi]['kaicheshijian'];
            $room->room_juli = $juli;
            $room->room_kaicheshijian = $kaicheshijian;
            $room->save();

            $key = 'UPDATE_ROOM_DISTANCE';
            $msg = "[bianhao: $bianhao][xiaoqu: $dizhi]"
                . "[juli: $juli][kaicheshijian: $kaicheshijian]";
            \Yii::info($msg, $key);
        }
    }
}
