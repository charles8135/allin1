#!/bin/bash

. myecho.sh

### 这是一个命令行交互的小工具
### 用法
# 使用方要生命一个命令集列表，之后调用cmd_runner $funcname

### 需要使用方对其进行复制，之后该工具才会生效
declare -a CMD_LIST=()

function echo_usage() {
    local str="Usage: $0 {"
    for cmd in ${CMD_LIST[@]}
    do
        str=${str}${cmd}"|"    
    done 
    str=$str"}"
    echo_info "$str"
}

function cmd_runner() {
    for cmd in ${CMD_LIST[@]} 
    do
        if [ "$cmd" == "$1" ]
        then
            $cmd
            return
        fi
    done 
    echo_usage
}
