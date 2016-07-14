#!/bin/bash

. ./conf.sh

### __sensitive__ ###
soft_tar_name="php-5.4.32.tar.gz"
soft_dir_name="php-5.4.32"

curl_tar_name="curl-7.21.0.tar.gz"
curl_dir_name="curl-7.21.0"

libmcrypt_tar_name="libmcrypt-2.5.8.tar.gz"
libmcrypt_dir_name="libmcrypt-2.5.8"

libpng_tar_name="libpng-1.5.8.tar.gz"
libpng_dir_name="libpng-1.5.8"

mhash_tar_name="mhash-0.9.7.1.tar.gz"
mhash_dir_name="mhash-0.9.7.1"

#openssl_tar_name="openssl-0.9.8g.tar.gz"
#openssl_dir_name="openssl-0.9.8g"
openssl_tar_name="openssl-1.0.2h.tar.gz"
openssl_dir_name="openssl-1.0.2h"

#zlib_tar_name="zlib-1.2.3.tar.gz"
#zlib_dir_name="zlib-1.2.3"
zlib_tar_name="zlib-1.2.8.tar.gz"
zlib_dir_name="zlib-1.2.8"

libxml2_tar_name="libxml2-2.6.26.tar.gz"
libxml2_dir_name="libxml2-2.6.26"

apc_tar_name="APC-3.1.13.tgz"
apc_dir_name="APC-3.1.13"

redis_tar_name="phpredis-master.zip"
redis_dir_name="phpredis-master"

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
tar zxf $CUR_DIR/src/$curl_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$libmcrypt_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$libpng_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$mhash_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$openssl_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$zlib_tar_name -C $CUR_DIR/src/compile
tar zxf $CUR_DIR/src/$libxml2_tar_name -C $CUR_DIR/src/compile

tar zxf $CUR_DIR/src/$apc_tar_name -C $CUR_DIR/src/compile
unzip $CUR_DIR/src/$redis_tar_name -d $CUR_DIR/src/compile

### install depends ###

#rm -rf $LOCAL_DIR/mhash
if [ ! -d $LOCAL_DIR/mhash ]; then
    cd $CUR_DIR/src/compile/$mhash_dir_name
    ./configure --prefix=$LOCAL_DIR/mhash 
    make
    make install
fi

#rm -rf $LOCAL_DIR/libpng
if [ ! -d $LOCAL_DIR/libpng ]; then
    cd $CUR_DIR/src/compile/$libpng_dir_name
    ./configure --prefix=$LOCAL_DIR/libpng
    make
    make install
fi

#rm -rf $LOCAL_DIR/libmcrypt
if [ ! -d $LOCAL_DIR/libmcrypt ]; then
    cd $CUR_DIR/src/compile/$libmcrypt_dir_name
    ./configure --prefix=$LOCAL_DIR/libmcrypt
    make
    make install
fi

#rm -rf $LOCAL_DIR/libxml2
if [ ! -d $LOCAL_DIR/libxml2 ]; then
    cd $CUR_DIR/src/compile/$libxml2_dir_name
    ./configure --prefix=$LOCAL_DIR/libxml2
    make
    make install
fi

#rm -rf $LOCAL_DIR/zlib
if [ ! -d $LOCAL_DIR/zlib ]; then
    cd $CUR_DIR/src/compile/$zlib_dir_name
    ./configure --prefix=$LOCAL_DIR/zlib --shared
    make
    make install
fi

#rm -rf $LOCAL_DIR/openssl
if [ ! -d $LOCAL_DIR/openssl ]; then
    cd $CUR_DIR/src/compile/$openssl_dir_name
    ./config --prefix=$LOCAL_DIR/openssl --shared
    make
    make install
fi

#rm -rf $LOCAL_DIR/curl
if [ ! -d $LOCAL_DIR/curl ]; then
    cd $CUR_DIR/src/compile/$curl_dir_name
    ./configure --prefix=$LOCAL_DIR/curl --with-ssl=$LOCAL_DIR/openssl --with-zlib=$LOCAL_DIR/zlib
    make
    make install
fi

cd $CUR_DIR/src/compile/$soft_dir_name

### __sensitive__ ###

./configure \
    --prefix=$INSTALL_DIR \
    --enable-fpm \
    --enable-fastcgi \
    --enable-bcmath \
    --enable-gd-native-ttf \
    --enable-mbstring \
    --enable-shmop \
    --enable-soap \
    --enable-sockets \
    --enable-exif \
    --enable-ftp \
    --enable-sysvsem \
    --enable-pcntl \
    --enable-wddx \
    --enable-zip \
    --with-curlwrappers \
    --with-openssl=$LOCAL_DIR/openssl \
    --with-curl=$LOCAL_DIR/curl \
    --with-mhash=$LOCAL_DIR/mhash \
    --with-zlib=$LOCAL_DIR/zlib \
    --with-iconv \
    --with-pear \
    --with-mysql=mysqlnd \
    --with-mysqli=mysqlnd \
    --with-pdo-mysql=mysqlnd \
    --with-jpeg-dir \
    --with-freetype-dir 

make 
make install

if [ $? -ne 0 ]; then
    echo "install php failed"
    exit
fi

### install extension ###

echo "install extension..."

PHP_EXT_DIR=`$INSTALL_DIR/bin/php-config --extension-dir`

cd $CUR_DIR/src/compile/$apc_dir_name
$INSTALL_DIR/bin/phpize
./configure --with-php-config=$INSTALL_DIR/bin/php-config
make 
make install

if [ $? -ne 0 ]; then
    echo "install apc failed"
    exit
fi


cd $CUR_DIR/src/compile/$redis_dir_name
$INSTALL_DIR/bin/phpize
./configure --with-php-config=$INSTALL_DIR/bin/php-config
make
make install
if [ $? -ne 0 ]; then
    echo "install phpredis failed"
    exit
fi

rm -rf $CUR_DIR/src/compile
echo "install $soft_dir_name done..."
