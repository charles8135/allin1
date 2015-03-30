<?php

namespace app\components\yii;

use yii\log;
use yii\web\Request;

/**
 * @file MyFileTarget.php
 * @Synopsis  对Yii的日志内容结构进行重构
 * @author liuyue01@baidu.com
 * @version 1.0.0
 * @date 2015-03-16
 */

class MyFileTarget extends log\FileTarget {

    public function getMessagePrefix($message) {
        if ($this->prefix !== null) {
            return call_user_func($this->prefix, $message);
        }

        $request = \Yii::$app->getRequest();
        $ip = $request instanceof Request ? $request->getUserIP() : '-';
        $reqId = \Yii::$app->bb->getReqInfo('reqId', 0);
        $curModule = \Yii::$app->bb->getReqInfo('curModule', '-');

        return [
            'ip' => $ip,
            'reqId' => $reqId,
            'module' => $curModule,
        ];
    }

    public function formatMessage($message) {
        list($text, $level, $category, $timestamp) = $message;
        $level = log\Logger::getLevelName($level);
        if (!is_string($text)) {
            $text = VarDumper::export($text);
        }
        $traces = [];
        if (isset($message[4])) {
            foreach($message[4] as $trace) {
                $traces[] = "in {$trace['file']}:{$trace['line']}";
            }
        }

        $prefix = $this->getMessagePrefix($message);
        
        $text = str_replace(array("\t", "\n"), '', $text);
        $logs = [
            'time' => date('Y-m-d H:i:s', $timestamp),
            'ip' => $prefix['ip'],
            'reqId' => $prefix['reqId'],
            'module' => $prefix['module'],
            'level' => $level,
            'category' => $category,
            'text' => $text,
        ];
        if (! empty($traces)) {
            $logs['traces'] = $traces[0];
        }
        return implode("\t", $logs);
    }
}
