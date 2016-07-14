#!/bin/bash

### Need Change
BASE_USER=$USER
BASE_DIR="/home/$BASE_USER/var/www-run/nginx"
NGINX_CONF_FILE=$BASE_DIR"/conf/nginx.conf"

NGINX_DIR="/home/$BASE_USER/my-local/nginx"
nginx=$NGINX_DIR"/sbin/nginx"

configtest() {
  $nginx -t -c $NGINX_CONF_FILE
}

function start(){
  configtest || return $?
  echo "mynginx start..."
  $nginx -p $BASE_DIR -c $NGINX_CONF_FILE
  retval=$?
  [ $retval -eq 0 ] || echo "start failed"
  return $retval
}

function stop(){
  echo "mynginx stop..."
  $nginx -s stop -p $BASE_DIR -c $NGINX_CONF_FILE
  retval=$?
  [ $retval -eq 0 ] || echo "stop failed"
  return $retval
}

function restart(){
  configtest || return $?
  echo "mynignx restart..."
  $nginx -s reload -p $BASE_DIR/
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
