#!/bin/bash

### Need Change
PORT=6600
MYSQL_VAR_DIR="$HOME/var/mysql"
MYSQL_DIR="$HOME/my-local/mysql"
MYSQLD_SAFE="$HOME/my-local/mysql/bin/mysqld_safe"

function start() {
    mkdir -p $MYSQL_VAR_DIR
    datadir=$MYSQL_VAR_DIR/mysql.$PORT
    mkdir -p $datadir
    $MYSQL_DIR/bin/mysqld_safe \
        --basedir=$MYSQL_DIR \
        --datadir=$datadir \
        --log-error=$MYSQL_VAR_DIR/mysql.$PORT.err \
        --pid-file=$MYSQL_VAR_DIR/mysql.$PORT.pid \
        --socket=$MYSQL_VAR_DIR/mysql.$PORT.sock \
        --port=$PORT &
}

function stop() {
    $MYSQL_DIR/bin/mysqladmin \
        -uroot -p \
        -S$MYSQL_VAR_DIR/mysql.$PORT.sock shutdown
    echo "mysql.$PORT stop..."
}

function restart() {
    stop
    start
    echo "mysql.$PORT restart..."
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
    *)
        echo "Usage: $0 {start|stop|restart}"
esac
exit 0
