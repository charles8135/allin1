#!/bin/bash

### ------ Shell通用配置
# 使用库函数之前，需要配置一下路径，以便加载各种库函数
cur_dir=`pwd`
util_inc_dir=$cur_dir/sh-util/inc
export PATH=$util_inc_dir:$PATH
. $util_inc_dir/boot.inc.sh
### ------

### ------ 应用程序配置
MYSQL_DIR=/home/liuyue01/my-local/mysql

### ------

function init() {
    if [ $# != 1 ]; then
        echo_warn "function usage: init <data dir>"
        return 0
    fi
    $MYSQL_DIR/bin/mysql_install_db --user=mysql --datadir=$1 
    if [ $? == 0 ]; then
        echo_info "mysql init ok..."
    else
        echo_error "mysql init fail..."
    fi
}

CMD_LIST=(init)
cmd_runner $@

exit 0
