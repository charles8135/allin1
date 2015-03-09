#!/bin/bash

. ./conf.sh

echo "config nginx..."

cp $INSTALL_DIR/conf/nginx.conf $INSTALL_DIR/conf/nginx.conf.bak.$CUR_DATE

cp $CUR_DIR/conf-sample/nginx.conf $INSTALL_DIR/conf/nginx.conf

mkdir -p $MY_BIN

cp $CUR_DIR/sbin/nginx.sh $MY_BIN

echo "config nginx done..."

