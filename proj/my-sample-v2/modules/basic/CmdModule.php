<?php

namespace app\modules\basic;

class CmdModule extends BaseModule {

    public function init() {
        parent::init();
        $this->_initMisc();
    }

}
