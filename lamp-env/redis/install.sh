#!/bin/bash

. ./conf.sh

### __sensitive__ ###
soft_tar_name="redis-2.8.11.tar.gz"
soft_dir_name="redis-2.8.11"

if [ ! -d "$INSTALL_DIR" ]; then 
    echo $INSTALL_DIR" is not exist..."
    mkdir -p $INSTALL_DIR
    echo "mkdir -p "$INSTALL_DIR
else
    echo $INSTALL_DIR" is exist, need rm ..."
    rm -rf $INSTALL_DIR
fi

rm -rf $CUR_DIR/src/compile
mkdir -p $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$soft_tar_name -C $CUR_DIR/src/compile

cd $CUR_DIR/src/compile/$soft_dir_name

### __sensitive__ ###
make -j4
make PREFIX=$INSTALL_DIR install

rm -rf $CUR_DIR/src/compile
echo "install $soft_dir_name done..."
