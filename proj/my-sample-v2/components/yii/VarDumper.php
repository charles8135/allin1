<?php

namespace app\components\yii;

class VarDumper {

    public static function export($mixValue) {
        if (is_resource($mixValue) || is_object($mixValue)) {
            return serialize($mixValue);
        } else {
            return json_encode($mixValue);
        }
    }
    
}
