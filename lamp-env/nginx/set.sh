#!/bin/bash

. ./conf.sh

##NEED CHANGE##
RUNTIME_DIR="$HOME/var/run-www-sample"
RUNTIME_NGINX_DIR=$RUNTIME_DIR"/nginx"

echo "config nginx..."

if [ -d $RUNTIME_NGINX_DIR ]; then
    echo "[ERROR] $RUNTIME_NGINX_DIR is exist..."
    exit 1
else 
    mkdir -p $RUNTIME_DIR
    cp -rf src/nginx $RUNTIME_DIR
    cp sbin/nginx.sh $RUNTIME_DIR
fi

echo "config nginx done..."

