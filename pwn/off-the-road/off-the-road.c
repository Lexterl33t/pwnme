#include <stdio.h>
#include <stdlib.h>

void getInput()
{
    char buffer[0x100] = {0};
    fread(buffer, sizeof(char), 257, stdin);
}

void main(int argc, char **argv)
{
    setvbuf(stdin, NULL, _IONBF, 0);
    setvbuf(stdout, NULL, _IONBF, 0);
    puts("Good luck ;)");
    getInput();
}