FROM alpine:3.16.0

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /app/

RUN apk add socat

COPY ./challenge/0x00b /app/
COPY ./entry.sh /app/
COPY ./flag.txt /app/

RUN addgroup -S ctf && \
    adduser -S player -G ctf

RUN mkdir /lib64 && ln -s /lib/libc.musl-x86_64.so.1 /lib64/ld-linux-x86-64.so.2


RUN chown player:ctf /app/0x00b
USER player
EXPOSE ${LISTEN_PORT}

ENTRYPOINT ["/bin/sh","/app/entry.sh"]