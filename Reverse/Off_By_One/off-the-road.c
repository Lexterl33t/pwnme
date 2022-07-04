#include <stdio.h>
#include <stdlib.h>

void getInput()
{
	char buffer[0x100] = {0};
	scanf("%257s", buffer);
}

void main(int argc, char **argv)
{
	setvbuf(stdin, NULL, _IONBF, 0);
	setvbuf(stdout, NULL, _IONBF, 0);
	getInput();
}