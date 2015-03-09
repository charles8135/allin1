<?php

namespace app\components\smarty;

use yii\base\ViewRenderer as BaseViewRenderer;

class ViewRenderer extends BaseViewRenderer {

    public function render($view, $file, $params) {

        //NOTICE 采用set方式把smarty注入进来是更好的方式
        $smarty = \Yii::$app->smarty;

        foreach($params as $k => $v) {
            $smarty->assign($k, $v);
        }

        $smarty->display($file);
    }

}
