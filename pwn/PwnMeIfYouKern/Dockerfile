FROM alpine:latest

ARG DEBIAN_FRONTEND=noninteractive
WORKDIR /app/

RUN apk add qemu qemu-system-x86_64 qemu-modules libvirt-daemon openssh-server bash

RUN ssh-keygen -A

RUN mkdir /lib64 && ln -s /lib/libc.musl-x86_64.so.1 /lib64/ld-linux-x86-64.so.2

COPY ./vm/start_vm /app/
COPY ./vm/._run /app/
COPY ./vm/initramfs.cpio.gz /app/
COPY ./vm/bzImage /app/
COPY ./vm/passwd.img /app/

RUN addgroup -S ctf && \
    adduser -S player -G ctf -G qemu -G kvm -h /app -s /bin/bash && \
    adduser -S player-privileged

RUN echo "player:pwnme-2600" | chpasswd

RUN chown player-privileged /app/passwd.img
RUN chmod 600 /app/passwd.img

RUN chown player-privileged /app/start_vm
RUN chmod 4755 /app/start_vm

RUN printf 'Welcode to PwnMeIfYouKern !\nYou can start the challenge by running ./start_vm\n\n' > /etc/motd

EXPOSE 22

ENTRYPOINT ["/usr/sbin/sshd", "-D"]