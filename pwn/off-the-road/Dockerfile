FROM ubuntu:18.04
MAINTAINER unknown
LABEL Description="off-the-road" VERSION='1.0'

#installation
RUN apt-get update
RUN apt-get install -y socat 

#user
RUN adduser --disabled-password --gecos '' pwn 
RUN chown -R root:pwn /home/pwn/
RUN chmod 750 /home/pwn

RUN touch /home/pwn/flag

RUN chmod 740 /usr/bin/top
RUN chmod 740 /bin/ps
RUN chmod 740 /usr/bin/pgrep
RUN export TERM=xterm

#Copying file
WORKDIR /home/pwn/
COPY off-the-road /home/pwn
COPY flag /home/pwn

#Setting perm.
RUN chown root:pwn /home/pwn/flag
RUN chmod +x /home/pwn/off-the-road
RUN chmod 440 /home/pwn/flag
EXPOSE ${LISTEN_PORT}

#Run the program with socat
CMD su pwn -c "socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:/home/pwn/off-the-road"