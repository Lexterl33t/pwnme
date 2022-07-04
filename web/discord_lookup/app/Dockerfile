FROM python:slim-bullseye

WORKDIR /app/

COPY --chown=root:root --chmod=400 ./requirements.txt /app/.

RUN \
        pip install --no-cache-dir -r requirements.txt &&\
        adduser ctf

COPY --chown=ctf:ctf --chmod=500 ./ /app/

USER ctf

CMD ["prlimit", "--nproc=0", "python3", "src/app.py"]
