<?php

namespace app\components\yii;

use yii\web\Controller as BaseController;

class Controller extends BaseController {

    public function __construct($id, $module, $config = []) {
        parent::__construct($id, $module, $config);
        $this->_init();
    }

    protected function _init() {
        //NOTICE 使用smarty模板后，目前看不需要使用layout功能
        //       暂时关闭该功能
        $this->layout = false;
    }

    public function renderJson($data) {
        $resp = \Yii::$app->response;    
        $resp->format = \yii\web\Response::FORMAT_JSON;
        $resp->data = $data;
    }

    //NOTICE 当前配置文件中声明的是全局过滤器，如果需要模块级的，可以通过配置文件配置每个模块的通用filter
    public function behaviors() {
        $globalFilters = \Yii::$app->params['filters']; 
        $config = [];
        foreach($globalFilters as $filter) {
            $config[] = [
                'class' => $filter,
            ];
        }
        $customerFilters = $this->_filters();
        if (is_array($customerFilters)) {
            foreach($customerFilters as $filter) {
                $config[] = $filter; 
            }
        }
        return $config;
    }

    //NOTICE 覆盖本方法，可以增加针对Controller级别的filter
    protected function _filters() {
        return [];
    }
}
