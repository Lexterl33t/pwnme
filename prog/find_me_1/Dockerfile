FROM ubuntu:18.04

#installation
RUN apt-get update
RUN apt-get install -y socat 

WORKDIR /app/

#user
RUN adduser --disabled-password --gecos '' player 
RUN chown -R root:player /app/
RUN chmod 750 /app


RUN chmod 740 /usr/bin/top
RUN chmod 740 /bin/ps
RUN chmod 740 /usr/bin/pgrep
RUN export TERM=xterm

#Copying file
COPY chall /app
COPY flag.txt /app

#Setting perm.
RUN chown root:player /app/flag.txt
RUN chmod +x /app/chall
RUN chmod 440 /app/flag.txt
EXPOSE ${LISTEN_PORT}

#Run the program with socat
CMD su player -c "socat TCP-LISTEN:${LISTEN_PORT},reuseaddr,fork EXEC:/app/chall"