#!/bin/bash

. ./conf.sh

$INSTALL_DIR/bin/mysql_install_db --user=mysql --datadir=$1
echo "grant table created..."
