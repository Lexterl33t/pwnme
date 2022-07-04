FROM ubuntu:18.04

WORKDIR /app/

RUN apt update
RUN apt install socat -y

COPY ./challenge/free_win /app/
COPY ./entry.sh /app/
COPY ./flag.txt /app/

RUN addgroup ctf && \
    adduser player && \
    usermod -aG ctf player

RUN chown player:ctf /app/free_win
USER player
EXPOSE ${LISTEN_PORT}

ENTRYPOINT ["/bin/sh","/app/entry.sh"]