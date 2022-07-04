FROM alpine:3.16.0

WORKDIR /app/

COPY ./challenge /app/


RUN chmod 777 /app/attack_equation_solving

ENTRYPOINT ["/app/attack_equation_solving"]