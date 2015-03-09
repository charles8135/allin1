#!/bin/bash

. ./conf.sh

if [ ! -d "$INSTALL_DIR" ]; then 
    echo $INSTALL_DIR" is not exist..."
    mkdir -p $INSTALL_DIR
    echo "mkdir -p "$INSTALL_DIR
else
    echo $INSTALL_DIR" is exist, need rm ..."
    rm -rf $INSTALL_DIR
fi

rm -rf $CUR_DIR/src/svn
mkdir -p $CUR_DIR/src/svn
tar zxf $CUR_DIR/src/subversion-1.6.17_with_dep.tar.gz -C $CUR_DIR/src/svn

cd $CUR_DIR/src/svn/subversion-1.6.17

./configure \
    --prefix=$INSTALL_DIR \
    --with-ssl      #支持https

make -j4
make install

rm -rf $CUR_DIR/src/svn
echo "install done..."
