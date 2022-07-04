FROM alpine:3.16.0

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /app/

RUN apk add socat python3

COPY ./chall.py /app/
COPY ./entry.sh /app/
COPY ./flag.txt /app/

RUN addgroup -S ctf && \
    adduser -S player -G ctf && \
    chmod u+s /app/chall.py && \
    chmod u+s /app/entry.sh


RUN chown player:ctf /app/chall.py
USER player
EXPOSE ${LISTEN_PORT}

ENTRYPOINT ["/bin/sh","/app/entry.sh"]