#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>
#include <sys/syscall.h>

#define STACK_SMASHING "**** stack smashing detected ***\n"
#define PREFIX "|=> "

struct formatter
{
    char *buffer;
    char check[8];
};

char *getRandomCanary(char *canary){
    FILE *f = fopen("/dev/urandom", "r");
    fread(canary, 1, 8, f);
    fclose(f);
    return canary;
}

int checkCanary(char *originalCanary, char *actualCanary){
    for(int i = 0; i < 8; i++){
        if(*actualCanary != *originalCanary){
            write(2, STACK_SMASHING, 33);
            syscall(0x3c, -1);
        }
        originalCanary++;
        actualCanary++;
    }

    return 1;
}

void showMessage(){
    printf("[+] W3lc0m3 t0 th3 b3s7 f0rm4tt3r [+]\n|\n");
}

int SIZE = 128;

void main(int argc, char **argv)
{
    struct formatter Formatter;
    char *canary = calloc(0, sizeof(char)*8);

    /* Disable buffering */
    setvbuf(stdin, NULL, _IONBF, 0);
    setvbuf(stdout, NULL, _IONBF, 0);

    /* Get the custom canary */
    getRandomCanary(Formatter.check);
    strncpy(canary, Formatter.check, 8);

    showMessage();

    int counter = 0;

    while(counter != 2)
    {
        printf("|- Enter your string -> ");
        if (!(Formatter.buffer = malloc(SIZE * sizeof(char)))){
            syscall(0x3c, -1);
        }

        fgets(Formatter.buffer, SIZE-1, stdin);
        checkCanary(canary, Formatter.check);

        write(1, PREFIX, 4);
        printf(Formatter.buffer);

        counter++;
    }

    syscall(0x3c, 1);
}