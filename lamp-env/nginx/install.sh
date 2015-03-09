#!/bin/bash

. ./conf.sh

### __sensitive__ ###
soft_tar_name="nginx-1.2.4.tar.gz"
soft_dir_name="nginx-1.2.4"

pcre_tar_name="pcre-8.31.tgz"
pcre_dir_name="pcre-8.31"

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
tar zxf $CUR_DIR/src/$pcre_tar_name -C $CUR_DIR/src/compile

cd $CUR_DIR/src/compile/$soft_dir_name

### __sensitive__ ###
./configure \
    --prefix=$INSTALL_DIR \
    --with-http_stub_status_module \
    --with-pcre=$CUR_DIR/src/compile/pcre-8.31

make -j4
make install

rm -rf $CUR_DIR/src/compile
echo "install $soft_dir_name done..."
