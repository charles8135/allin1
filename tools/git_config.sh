#!/bin/bash

git config --global user.name "liuyue"
git config --global user.email charles8135@gmail.com
git config --global merge.tool vimdiff

echo "check git config info..."
git config --list

echo "generate ssh keygen..."
ssh-keygen -t rsa -C "charles8135@gmail.com"
