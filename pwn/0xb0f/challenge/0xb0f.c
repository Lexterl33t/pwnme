#include <time.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <unistd.h>

uint8_t shell_enabled = 0;

void enable_shell(uint32_t check)
{
    if (check == 0xcafec0de)
    {
        shell_enabled = 1;
        printf("[+] Shell enabled\n");
    }
    else
    {
        shell_enabled = 0;
        printf("[-] Shell disabled\n");
    }
}

void shell(uint32_t check)
{
    if (check == 0xdeadbeef)
    {
        if (shell_enabled == 1)
        {
            printf("[+] Launching shell...\n");
            execve("/bin/sh", NULL, NULL);
        }
        else
        {
            printf("[-] Shell not enabled yet\n");
        }
    }
    else
        printf("[-] Wrong value !\n");
}

uint32_t get_int_input()
{
    char buffer[10];

    printf("Give me a number: ");
    fflush(stdout);
    gets(buffer);

    return atol(buffer);
}

int main()
{
    srand(time(NULL));

    printf("[+] You %s\n",
           (char *[]){"lost", "won"}[(rand() % 2) == (get_int_input() % 2)]);
}
