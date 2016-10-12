#!/bin/bash
                               
### Need Change                
PORT=6600
MYSQL_DIR="$HOME/my-local/mysql"
SOCK_FILE="/home/liuyue01/var/run-www-sample/mysql/mysql.sock"

function root_login() {
    #$MYSQL_DIR/bin/mysql -h127.0.0.1 -uroot -P$PORT -p
    $MYSQL_DIR/bin/mysql -S $SOCK_FILE -uroot -p
}

function login() {             
    $MYSQL_DIR/bin/mysql -h127.0.0.1 -umysql -P$PORT -p
}

## main()
case "$1" in
    "root_login")
        root_login 
        ;;
    "login")
        login 
        ;;
    *)
        echo "Usage: $0 {login|root_login}"
esac
exit 0
