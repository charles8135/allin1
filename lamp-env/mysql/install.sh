#!/bin/bash

. ./conf.sh

### __sensitive__ ###
soft_tar_name="mysql-5.1.73.tar.gz"
soft_dir_name="mysql-5.1.73"

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
./configure \
    --prefix=$INSTALL_DIR \
    --with-charset=utf8 \
    --with--enable-local-infile \
    --with-extra-charset=all \
    --enable-thread-safe-client \
    --with-plugins=innobase

make -j4
make install

rm -rf $CUR_DIR/src/compile
echo "install $soft_dir_name done..."
