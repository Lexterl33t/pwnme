#!/bin/bash

while :
do
    socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'./free_win,stderr';
done