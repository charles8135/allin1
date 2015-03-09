#!/bin/bash

BASE_USER=$USER
BASE_DIR="/home/$BASE_USER/local/ui-run"
FPM_CONF_FILE=$BASE_DIR"/fpm.conf"
PHP_CONF_FILE=$BASE_DIR"/php.ini"
FPM_PID_FILE=$BASE_DIR"/php.pid"
phpfpm="/home/$BASE_USER/local/php/sbin/php-fpm"

configtest() {
  $phpfpm -t -y $FPM_CONF_FILE
}

function is_running(){
  if [ ! -e $FPM_PID_FILE ] || [ -z $FPM_PID_FILE ]; then
    echo "php-fpm is not running"
    exit 1
  fi
  return 0
}

function start(){
  configtest || return $?
  echo "php-fpm start..."
  $phpfpm -g $FPM_PID_FILE -c $PHP_CONF_FILE -y $FPM_CONF_FILE 
  retval=$?
  [ $retval -eq 0 ] || echo "start failed"
  return $retval
}

function stop(){
  is_running
  echo "php-fpm stop..."
  kill -INT `cat $FPM_PID_FILE`
  retval=$?
  [ $retval -eq 0 ] || echo "stop failed"
  return $retval
}

function restart(){
  configtest || return $?
  is_running
  echo "php-fpm restart..."
  kill -USR2 `cat $FPM_PID_FILE`
  retval=$?
  [ $retval -eq 0 ] || echo "restart failed"
  return $retval
}

## main()
case "$1" in
    "start")
        start
        ;;
    "stop")
        stop
        ;;
    "restart")
        restart
        ;;
    "configtest")
        configtest
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|configtest}"
esac
exit 0
