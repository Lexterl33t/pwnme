FROM alpine:3.16.0

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /app/

RUN apk add openssh-server openssh-sftp-server bash python3

RUN ssh-keygen -A

COPY ./challenge/vuln /app/
COPY ./flag.txt /app/

RUN addgroup -S ctf && \
    adduser -S player -G ctf -s /bin/bash -h /app && \
    adduser -S player-privileged -G ctf

RUN echo "player:pwnme-2600" | chpasswd

RUN mkdir /lib64 && ln -s /lib/libc.musl-x86_64.so.1 /lib64/ld-linux-x86-64.so.2

RUN chown player-privileged /app/flag.txt
RUN chmod 600 /app/flag.txt

RUN chown player-privileged /app/vuln
RUN chmod 4755 /app/vuln

RUN printf 'Welcode to `Strong Primitive` !\nYou can start the challenge by running ./vuln\n\n' > /etc/motd

# EXPOSE 22

ENTRYPOINT ["/usr/sbin/sshd", "-D"]