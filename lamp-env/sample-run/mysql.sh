#!/bin/bash

### Need Change
BASE_USER=$USER
BASE_DIR="/home/$BASE_USER/var/www-run/mysql"
MYSQL_CONF_FILE=$BASE_DIR"/my.cnf"
MYSQL_PID_FILE=$BASE_DIR"/mysql.pid"

MYSQL_DIR="/home/$BASE_USER/my-local/mysql"

function start(){
  nohup $MYSQL_DIR/bin/mysqld_safe --defaults-file=$MYSQL_CONF_FILE &
  retval=$?
  [ $retval -eq 0 ] || echo "start failed"
  echo "mysql start..."
  return $retval
}

function stop(){
  kill -QUIT `cat $MYSQL_PID_FILE`
  retval=$?
  [ $retval -eq 0 ] || echo "stop failed"
  echo "mysql stop..."
  return $retval
}

function reload(){
  kill -HUP `cat $MYSQL_PID_FILE`
  retval=$?
  [ $retval -eq 0 ] || echo "reload failed"
  echo "mysql reload..."
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
    "reload")
        reload 
        ;;
    *)
        echo "Usage: $0 {start|stop|reload}"
esac
exit 0
