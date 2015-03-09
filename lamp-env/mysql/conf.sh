#!/bin/bash

. ../conf.sh

CUR_DIR=`pwd`
CUR_DATE=`date +%Y%m%d`

LOCAL_DIR=$HOME_DIR"/my-local"
INSTALL_DIR=$LOCAL_DIR"/mysql"

## 创建授权表用的datadir
DATA_DIR=$HOME_DIR/var/mysql/

## root密码设置
ROOT_PWD=shrimp


