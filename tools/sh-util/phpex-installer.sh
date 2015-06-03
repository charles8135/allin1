#!/bin/bash

### ------ 
# 使用库函数之前，需要配置一下路径，以便加载各种库函数
cur_dir=`pwd`
util_dir=$cur_dir/inc
export PATH=$util_dir:$PATH
. $util_dir/boot.inc.sh
### ------

ex_dir=$1
php_dir=$2

if [ ! -d "$ex_dir" ]; then
    echo_error "$ex_dir does not exist!"
    exit 1
fi

if [ ! -d "$php_dir" ]; then
    echo_error "$php_dir does not exist!"
    exit 1
fi

cd $ex_dir
$php_dir/bin/phpize
./configure --with-php-config=$php_dir/bin/php-config
make
make install

echo_info "$ex_dir install ok"
exit 0
