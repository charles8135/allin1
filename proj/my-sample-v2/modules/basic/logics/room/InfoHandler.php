<?php

/**
 * @file InfoHandler.php
 * @Synopsis  房屋信息解析处理
 * @author liuyue01@baidu.com
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

                $this->_initRoom();
                $this->_roomInfo['url'] = $roomUrl;
                $this->_parseInfo($roomUrl);
                $this->_otherInfo();
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

    protected function _initRoom() {
        foreach($this->_roomInfo as $k => $v) {
            $this->_roomInfo[$k] = '';
        }
        $this->_roomHtml = '';
    }

    protected function _parseInfo($url) {

        $this->_roomHtml = str_replace(
                "\n", ' ',
                file_get_contents($url));
        if (empty($this->_roomHtml)) {
            throw new env\BizException('GET_HTML_ERR');
        }

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
            . $this->_roomInfo['quxian']    
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
        $bianhao = $this->_roomInfo['bianhao'];
        $time = date('Y-m-d H:i:s');
        $date = date('Y-m-d');

        $room = models\RoomInfo::find()
            ->where(['room_bianhao' => $bianhao])
            ->one();
        if ($room == null) {
            $room = new models\RoomInfo();
            $room->create_time = $time;
            $room->status = 0;
        } else {
            $oldPrice = json_decode($room->room_lishijiage, true);
        }
        $oldPrice[$date] = $this->_roomInfo['zongjia'];

        $room->room_lishijiage = json_encode($oldPrice);
        $room->update_time = $time;

        foreach($this->_roomInfo as $k => $v) {
            $key = 'room_' . $k;
            $room->$key = $v;
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
