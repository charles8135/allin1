<?php

namespace app\components\smarty;

require_once(DIR_VENDOR . '/thirdpart/Smarty/Smarty.class.php');

class SmartyAdapter extends \Smarty {
    
    public function __construct() {
        parent::__construct();
    }

    public function init($config) {
        $this->template_dir = $config['template_dir'];
        $this->compile_dir = $config['compile_dir'];
        $this->left_delimiter = '<!--{';
        $this->right_delimiter = '}--!>';
    }
}
