#!/bin/bash

### Need Change
RUNTIME_DIR="$HOME/var/run-www-sample/nginx"
NGINX_DIR="$HOME/my-local/nginx"
nginx=$NGINX_DIR"/sbin/nginx"

configtest() {
  $nginx -t -p $RUNTIME_DIR/
}

function start(){
  configtest || return $?
  echo "mynginx start..."
  $nginx -p $RUNTIME_DIR/
  retval=$?
  [ $retval -eq 0 ] || echo "start failed"
  return $retval
}

function stop(){
  echo "mynginx stop..."
  $nginx -s stop -p $RUNTIME_DIR/
  retval=$?
  [ $retval -eq 0 ] || echo "stop failed"
  return $retval
}

function restart(){
  configtest || return $?
  echo "mynignx restart..."
  $nginx -s reload -p $RUNTIME_DIR/
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
