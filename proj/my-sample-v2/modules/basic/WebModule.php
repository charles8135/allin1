<?php

namespace app\modules\basic;

class WebModule extends BaseModule {

    public function init() {
        parent::init();
        $this->_initSmarty();
        $this->_initMisc();
    }

}
