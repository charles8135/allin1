#!/bin/bash

### 在显示的信息前加绿色的INFO
function echo_info() {
    echo -e "\033[1;32m[INFO]\033[0m $1"
}

### 在显示的信息前加红色的ERROR
function echo_error() {
    echo -e "\033[1;31m[ERROR]\033[0m $1"
}

### 在显示的信息前加黄色的WARNING
function echo_warn() { 
    echo -e "\033[1;33m[WARNING]\033[0m $1"
}


### TEST
function func_test() {
    echo_info "hello world"
    echo_error "hello world"
    echo_warn "hello world"
}

#func_test
