#!/bin/bash

while :
do
    socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'./0x00b,stderr';
done