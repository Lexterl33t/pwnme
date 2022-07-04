FROM python:3.9-slim-buster
WORKDIR /app

COPY chall.py /app/chall.py
COPY entry.sh /app/entry.sh
COPY flag.txt /app/flag.txt
COPY requirements.txt /app/requirements.txt
RUN  apt update
RUN  apt install socat -y
RUN    adduser --system --group player 
RUN    chmod u+s /app/chall.py 
RUN    chmod u+s /app/entry.sh

RUN python -m pip install --upgrade pip setuptools wheel
RUN python -m pip install -U --no-cache-dir -r /app/requirements.txt
USER player

EXPOSE ${LISTEN_PORT}

ENTRYPOINT ["/bin/sh","/app/entry.sh"]