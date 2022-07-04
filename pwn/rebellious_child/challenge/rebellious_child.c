#include <sys/wait.h>
#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <unistd.h>
#include <assert.h>

char buffer[0x100];

int main()
{
    setvbuf(stdout, NULL, _IONBF, 0);
    setvbuf(stderr, NULL, _IONBF, 0);

    uint32_t cont = 1;

    while (cont)
    {
        memset(buffer, 0, 0x100);
        puts("What's your name?");
        fgets(buffer, 0x100, stdin);

        uint32_t pid = fork();

        if (pid == 0)
        {
            uint8_t exit_code = 1;

            for (char *ptr = buffer; *ptr != '\n'; ptr++)
                exit_code |= *ptr;

            exit(exit_code);
        }

        int32_t status;
        waitpid(pid, &status, 0);

        printf("Welcome ");

        if (WEXITSTATUS(status) == 0)
            printf(buffer);
        else
            puts("stranger");
    }
}
