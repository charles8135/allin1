#!/bin/bash

### ------ 
# 使用库函数之前，需要配置一下路径，以便加载各种库函数
cur_dir=`pwd`
util_dir=$cur_dir/../
export PATH=$util_dir:$PATH
. $util_dir/boot.inc.sh
### ------


function a() {
    echo_info a
}

function b() {
    echo_info b
}

function c() {
    echo_info c
}

CMD_LIST=(a b c)
cmd_runner $1

exit 0
