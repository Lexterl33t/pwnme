#include <unistd.h>

int main()
{
    char *args[] = {
        "./._run",
        NULL,
    };

    execve(args[0], args, NULL);
}