#!/bin/bash

. ./conf.sh

echo "set profile..."

my_profile_path=$HOME_DIR/my-profile

if [ ! -d $my_profile_path ]; then
    # 加入个人的个性化配置文件
    mkdir -p $my_profile_path
    cp $CUR_DIR/src/my_bash_profile $my_profile_path
    echo -e '\n' >> $HOME_DIR/.bash_profile
    echo "[ -s "$my_profile_path" ] && source "$my_profile_path/my_bash_profile >> $HOME_DIR/.bash_profile
    echo "source $HOME_DIR/.bash_profile"
else
    echo $my_profile_path" has exist..."
fi

# 创建快捷链接
mkdir -p $MY_BIN
cd $MY_BIN
if [ -s $HOME_DIR/my-local/svn/bin/svn ]; then
    [ -s $MY_BIN/svn ] && rm $MY_BIN/svn
    ln -s $HOME_DIR/my-local/svn/bin/svn
fi
if [ -s $HOME_DIR/my-local/vim/bin/vim ]; then
    [ -s $MY_BIN/vim ] && rm $MY_BIN/vim
    [ -s $MY_BIN/vimdiff ] && rm $MY_BIN/vimdiff
    ln -s $HOME_DIR/my-local/vim/bin/vim
    ln -s $HOME_DIR/my-local/vim/bin/vimdiff
fi

# 更新screen配置文件
cp $CUR_DIR/src/.screenrc $HOME_DIR

# 给bin中增加各种工具
cp $CUR_DIR/src/bin/* $MY_BIN

# 替换svn diff命令

if [ -s $HOME_DIR/.subversion/config ]; then
    sed 's/# diff-cmd = diff_program (diff, gdiff, etc.)/diff-cmd = svndiff/g' $HOME_DIR/.subversion/config > $CUR_DIR/src/config
    mv $CUR_DIR/src/config $HOME_DIR/.subversion/config
fi

