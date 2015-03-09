#!/bin/bash

### Need Change
PORT=9876
REDIS_SERVER_BIN=/home/users/liuyue01/my-local/redis/bin/redis-server
REDIS_CLIENT_BIN=/home/users/liuyue01/my-local/redis/bin/redis-cli
REDIS_CONF=/home/users/liuyue01/allin1/lamp-env/redis/conf-sample/redis.conf

function start() {
    nohup $REDIS_SERVER_BIN $REDIS_CONF &
}

function stop() {
    $REDIS_CLIENT_BIN -p $PORT shutdown
}

function restart() {
    stop
    start
    echo "redis.$PORT restart..."
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
