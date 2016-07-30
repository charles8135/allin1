<?php

/**
 * @file List.php
 * @Synopsis 根据种子URL列表，获取房屋List
 * @author charles8135@gmail.com
 * @version 
 * @date 2016-07-21
 */

namespace app\modules\basic\logics\room;

use app\components\env;

class ListHandler {

    protected $_urls = array();

    protected $_roomList = array();

    public function __construct($listUrls) {
        $this->_urls = $listUrls;
    }

    /**
     * 处理得到所有房屋列表 
     * 
     * @access public
     * @return void
     */
    public function handle() {
        foreach($this->_urls as $url) {
            try {
                $this->_crabList($url);        
            } catch (env\AppException $e) {
                $e->logEx();
                continue;
            }
        }
    }

    /**
     * 获取解析结果列表 
     * 
     * @access public
     * @return void
     */
    public function getRes() {
        return $this->_roomList; 
    }

    /**
     * 从一个种子URL中获取所有列表 
     * 
     * @access protected
     * @return void
     */
    protected function _crabList($listUrl) {
        $curPage = 1;
        $pageUrl = "";
        $prePageTag = "";
        $curPageTag = "";
        while(true) {
            $pageUrl = $listUrl . "pg$curPage/";

            \Yii::info("[curPage: $curPage] [pageUrl: $pageUrl]", "LIST_HANDLE_BEGIN");

            $html = file_get_contents($pageUrl); 
            $reg = '/<ul class="listContent" log-mod="list">(.*)<\/ul>/';
            $res = @preg_match($reg, $html, $matches);
            if ($res != 1) {
                $key = 'CRAB_LIST_ERR';
                $msg = "[url: $listUrl] [reg: $reg]";
                \Yii::error($msg, $key);    
                throw new env\BizException("CRAB_LIST_ERR");
            }
            $listHtml = $matches[1];
            
            $curPageTag = md5($listHtml);
            if ($curPageTag == 1) {
                $prePageTag = $curPageTag;
            } else if ($curPageTag == $prePageTag) {
                \Yii::info("[curPage: $curPage] [pageUrl: $pageUrl]",
                        "LIST_HANDLE_REPEAT_OVER");
                break;
            } else {
                $prePageTag = $curPageTag;
            }

            try {
                $this->_parseList($listHtml);
            } catch(env\AppException $e) {
                $e->logEx();
            }

            \Yii::info("[curPage: $curPage] [pageUrl: $pageUrl]", "LIST_HANDLE_OK");
            $curPage++;
        }
    }

    /**
     * 从列表页HTML中解析房屋列表 
     * 
     * @access protected
     * @return void
     */
    protected function _parseList($listHtml) {
        $reg = '/<div class="title"><a href="(.*?)" target="_blank" data-bl="list"/';
        $res = @preg_match_all($reg, $listHtml, $matches);
        if ($res == 0) {
            $key = 'PARSE_LIST_ERROR';
            $msg = "[reg: $reg]";
            \Yii::error($msg, $key);
            throw new env\BizException('PARSE_LIST_ERROR');
        }
        $res = $matches[1];
        foreach($res as $url) {
            $this->_roomList[$url] = $url;
            $key = 'PARSE_ROOM_ADD';
            $msg = "[url: $url]";
            \Yii::info($msg, $key);
        }
    }

}
