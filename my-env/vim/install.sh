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

rm -rf $CUR_DIR/src/vim
mkdir -p $CUR_DIR/src/vim
tar jxf $CUR_DIR/src/vim-7.4.tar.bz2 -C $CUR_DIR/src/vim

cd $CUR_DIR/src/vim/vim74

./configure \
    --prefix=$INSTALL_DIR \
    --with-features=huge \      #支持最大特性
    --enable-rubyinterp \       #启用Vim对ruby编写的插件的支持
    --enable-pythoninterp \     #启用Vim对python编写的插件的支持
    --enable-perlinterp \       #启用Vim对perl编写的插件的支持
    --enable-cscope \           #启用Vim对cscope支持
    --enable-luainterp \        #启用Vim对lua编写的插件的支持
    --enable-multibyte          #多字节支持 可以在Vim中输入中文 ** 非常重要 **

make
make install

rm -rf $CUR_DIR/src/vim

echo "install done..."
