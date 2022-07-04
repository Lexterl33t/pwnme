#!/bin/bash

while :
do
    socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'python3.10 ./chall.py,stderr';
done