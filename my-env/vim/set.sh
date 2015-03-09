#!/bin/bash

. ./conf.sh

echo "config vim..."

rm -rf $HOME_DIR"/.vim"
rm -rf $HOME_DIR"/.vimrc"

cp -rf $CUR_DIR"/src/.vim" $HOME_DIR"/.vim"
cp -rf $CUR_DIR"/src/.vimrc" $HOME_DIR"/.vimrc"

echo "config finished..."
