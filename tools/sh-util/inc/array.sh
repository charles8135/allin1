#!/bin/bash

### 获取一个数组
function array() {
    local func_array_arr=(`echo $*`)
    echo ${func_array_arr[@]}
}

### 获取一个数组的长度
function array_length() {
    local func_al_arr=(`echo $*`)
    return ${#func_al_arr[@]} 
}

### 遍历一个数组, 执行一个函数
function array_foreach() {
    local func_name=$1
    shift
    local arr=(`echo $*`)
    for i in ${arr[@]} 
    do
        $func_name $i
    done
}

### TEST
function my_echo() {
    echo $1
}
function func_test() {
    local tmp=(`array 8 2 3 4`)
    echo ${tmp[@]} 
    array_length ${tmp[@]}
    echo $?
    array_foreach "my_echo" ${tmp[@]}
}

#func_test
