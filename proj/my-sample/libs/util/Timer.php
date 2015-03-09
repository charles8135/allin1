<?php

namespace app\libs\util;

class Timer {

    //NOTICE 获取当前时间戳的微妙数
    public function microtime() {
        return intval(microtime(true) * 1000 * 1000);
    }

    public function millitime() {
        return intval(microtime(true) * 1000);
    }

}
