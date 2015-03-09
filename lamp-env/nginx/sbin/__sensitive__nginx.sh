#!/bin/bash

### Need Change
BASE_DIR="$HOME/my-local/nginx"
NGINX_PID_FILE=$BASE_DIR"/logs/nginx.pid"


nginx=$BASE_DIR"/sbin/nginx"
NGINX_CONF_FILE=$BASE_DIR"/conf/nginx.conf"

configtest() {
  $nginx -t -c $NGINX_CONF_FILE
}

function start(){
  configtest || return $?
  echo "mynginx start..."
  $nginx -c $NGINX_CONF_FILE -p $BASE_DIR/
  retval=$?
  [ $retval -eq 0 ] || echo "start failed"
  return $retval
}

function stop(){
  echo "mynginx stop..."
  $nginx -s stop
  retval=$?
  [ $retval -eq 0 ] || echo "stop failed"
  return $retval
}

function restart(){
  configtest || return $?
  echo "mynignx restart..."
  $nginx -s reload
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
