#!/bin/bash

# while :
# do
socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:'./formatter,stderr';
# done