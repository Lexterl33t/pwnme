FROM ubuntu:18.04

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /app/

RUN dpkg --add-architecture i386
RUN apt update
RUN apt install socat libc6-i386 -y

COPY ./challenge/0xb0f /app/
COPY ./entry.sh /app/
COPY ./flag.txt /app/

RUN addgroup ctf && \
    adduser player && \
    usermod -aG ctf player


RUN chown player:ctf /app/0xb0f
USER player
EXPOSE ${LISTEN_PORT}

ENTRYPOINT ["/bin/sh","/app/entry.sh"]