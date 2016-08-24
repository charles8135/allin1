<?php

/**
 * @file InfoHandler.php
 * @Synopsis  房屋信息解析处理
 * @author charles8135@gmail.com
 * @version 1.0.0
 * @date 2016-07-25
 */

namespace app\modules\basic\logics\room;

use app\components\env;
use app\modules\basic\models;

class InfoHandler {
    
    protected $_urlList = array();
    protected $_failList = array();
    protected $_roomHtml = '';

    protected $_roomInfo = array(
        'biaoti' => '',            
        'zongjia' => '',            
        'url' => '',            
        'danjia' => '',            
        'jushi' => '',            
        'chaoxiang' => '',            
        'mianji' => '',            
        'xiaoqu' => '',            
        'bianhao' => '',            
        'dizhi' => '',            
        'tupian' => '',            
        'dianti' => '',            
        'nianxian' => '',            
        'weiyi' => '',            
        'maidian' => '',            
        'kanfang' => '',            
        'quxian' => '',            
        'shoufu' => '',            
        'huankuan' => '',            
        'guanzhu' => '',            
        'nianling' => '',            
        'pubtime' => '',            
        'louceng' => '',            
        'status' => '0',            

    );

    public function __construct($urls) {
        $this->_urlList = $urls;
    }

    public function getFailList() {
        return $this->_failList;         
    }

    public function handle() {
        $suc = 0;
        $fail = 0;
        foreach($this->_urlList as $roomUrl) {
            try {
                $key = 'HANDLE_ROOM_INFO_BEGIN';
                $msg = "[roomUrl: $roomUrl]";
                \Yii::info($msg, $key);

                $this->_initRoom($roomUrl);
                $this->_preStatus();
                if ($this->_roomInfo['status'] == 0) {
                    $this->_parseInfo();
                    $this->_otherInfo();
                }
                $this->_saveInfo();

                //NOTICE 间隔一段时间，简单的防屏蔽策略
                usleep(300 * 1000);

                $suc++;
                $key = 'HANDLE_ROOM_INFO_OK';
                $msg = "[roomUrl: $roomUrl]";
                \Yii::info($msg, $key);
            } catch(env\AppException $e) {
                $e->logEx();

                $key = 'HANDLE_ROOM_INFO_EX';
                $msg = "[roomUrl: $roomUrl]";
                \Yii::warning($msg, $key);
                $fail++;
                $this->_failList[] = $roomUrl;
                continue;
            }
        }
        $key = 'ROOM_HANDLE_STAT';
        $msg = "[suc: $suc] [fail: $fail]";
        \Yii::info($msg, $key);
        echo $msg, "\n";
    }

    protected function _initRoom($roomUrl) {
        foreach($this->_roomInfo as $k => $v) {
            $this->_roomInfo[$k] = '';
        }
        $this->_roomHtml = '';
        $this->_roomInfo['url'] = $roomUrl;

        $this->_roomHtml = str_replace(
                "\n", ' ',
                file_get_contents($this->_roomInfo['url']));
        if (empty($this->_roomHtml)) {
            throw new env\BizException('GET_HTML_ERR');
        }
    }

    //NOTICE 先处理一下这个房屋的状态, 
    //       如果没入库就已经状态失效，则直接抛弃, 否则更新状态
    protected function _preStatus() {
        $regXiajia2 = '/<span>已下架<\/span>/';
        $regChengjiao = '/class="chengjiao"/';

        $matchXiajia2 = Util::extraInfo($regXiajia2, $this->_roomHtml, false);
        $matchChengjiao = Util::extraInfo($regChengjiao, $this->_roomHtml, false);

        if ($matchXiajia2) {
            $this->_roomInfo['status'] = Config::$ROOM_STATUS_XIAJIA;
        }
        if ($matchChengjiao) {
            $this->_roomInfo['status'] = Config::$ROOM_STATUS_CHENGJIAO;
        }
        if ($this->_roomInfo['status'] != Config::$ROOM_STATUS_OK) {
            $room = models\RoomInfo::find()
                ->where(['room_url' => $this->_roomInfo['url']])
                ->one();
            if (! $room) {
                $key = 'ROOM_NOTOK_NOT_EXIST';
                $msg = "[url: {$this->_roomInfo['url']}]"
                    . "[status: {$this->_roomInfo['status']}]";
                throw new env\BizException($key);
            }
        }
    }

    protected function _parseInfo() {
        $roomInfo = array(
            'biaoti' => ['/<h1 class="main" title="(.*?)"/', 1],
            'zongjia' => ['/<span class="total">(.*?)<\/span>/', 1],
            'danjia' => ['/<span class="unitPriceValue">(.*?)<i>/', 1],
            'jushi' => [
                '/<li><span class="label">房屋户型<\/span>(.*?)<\/li>/',
                1,
            ],
            'chaoxiang' => [
                '/<li><span class="label">房屋朝向<\/span>(.*?)<\/li>/',
                1,
            ],
            'mianji' => [
                '/<div class="area">(.*?)<div class="mainInfo">(.*?)<\/div>/',
                2,
            ],
            'xiaoqu' => [
                '/<a href="\/xiaoqu(.*?)class="info">(.*?)<\/a>/',
                2,
            ],
            'bianhao' => [
                '/<div class="houseRecord">(.*?)<span class="info">(\d*)(.*?)<span class="jubao">/',
                2,
            ],
            'dianti' => [
                '/<li><span class="label">梯户比例<\/span>(.*?)<\/li>/',
                1,
            ],
            'nianxian' => [
                '/<li><span class="label">房本年限<\/span>(.*?)<\/li>/',
                1,
            ],
            'weiyi' => [
                '/<li><span class="label">是否唯一<\/span>(.*?)<\/li>/',
                1,
            ],
            'quxian' => [
                '/<span class="label">所在区域<\/span>(.)*?lank">(.*?)<\/a>/',
                2,
            ],
            'guanzhu' => [
                '/<div class="notice-num"><span id="favCount">(.*?)<\/span>/',
                1,
            ],
            'nianling' => [
                '/<div class="subInfo">(\d+?)年建/',
                1,
            ],
            'pubtime' => [
                '/<li><span class="label">挂牌时间<\/span>(.*?)<\/li>/',
                1,
            ],
            'louceng' => [
                '/<li><span class="label">所在楼层<\/span>(.*?)<\/li>/',
                1,
            ],
        );

        foreach($roomInfo as $key => $reg) {
            $roomInfo[$key] = '';
            if ($reg[0] != '') {
                $matches = Util::extraInfo($reg[0], $this->_roomHtml);        
                $this->_roomInfo[$key] = $matches[$reg[1]];        
            }
        }
    }

    //NOTICE dizhi,tupian,shoufu,huankuan,kanfang
    protected function _otherInfo() {
        $this->_roomInfo['dizhi'] = '北京市' 
            . $this->_roomInfo['quxian'] . '区'    
            . $this->_roomInfo['xiaoqu'];    
        $kanfangUrl =
            'http://bj.lianjia.com/ershoufang/showcomment?&id=' . $this->_roomInfo['bianhao'];
        $tmp = json_decode(file_get_contents($kanfangUrl), true);
        if (!empty($tmp)) {
            $this->_roomInfo['kanfang'] = $tmp['data']['totalSeeRecordNum']; 
        }
        
        //NOTICE tupian
        $reg = '/<ul class="smallpic">(.*?)<\/ul>/';
        $matches = Util::extraInfo($reg, $this->_roomHtml);
        if ($matches !== false) {
            $picHtml = $matches[1];   
            $reg = '/<li data-src="(.*?)" data-desc="(.*?)">/';
            $res = @preg_match_all($reg, $picHtml, $matches);
            foreach($matches[1] as $key => $picUrl) {
                $this->_roomInfo['tupian'][$picUrl] = $matches[2][$key];        
            }
            $this->_roomInfo['tupian'] = json_encode($this->_roomInfo['tupian']);
        }

    }

    protected function _saveInfo() {
        $url = $this->_roomInfo['url'];
        $time = date('Y-m-d H:i:s');
        $date = date('Y-m-d');

        $room = models\RoomInfo::find()
            ->where(['room_url' => $url])
            ->one();
        if ($room == null) {
            $room = new models\RoomInfo();
            $room->create_time = $time;
            $bianhao = $this->_roomInfo['bianhao'];
        } else {
            $bianhao = $room->room_bianhao;
            $oldPrice = json_decode($room->room_lishijiage, true);
        }
        $oldPrice[$date] = $this->_roomInfo['zongjia'];

        $room->room_lishijiage = json_encode($oldPrice);
        $room->update_time = $time;

        if ($this->_roomInfo['status'] != 0) {
            $room->room_status = $this->_roomInfo['status'];    
        } else {
            foreach($this->_roomInfo as $k => $v) {
                if (strlen($v) > 0) {
                    $key = 'room_' . $k;
                    $room->$key = $v;
                }
            }
        }
        try {
            $room->save();
            echo 'save_ok:' . $bianhao . "\n";
        } catch (\Exception $e) {
            env\Util::logEx($e);
            echo 'save_fail:' . $bianhao . "\n";
            throw new env\BizException('SAVE_ERROR');
        }
    }

}
