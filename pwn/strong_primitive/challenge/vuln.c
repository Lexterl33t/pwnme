#include <stdio.h>
#include <stdlib.h>

struct action
{
    enum
    {
        ACTION_READ = 0,
        ACTION_WRITE = 1,
    } type;
    void *address;
    size_t size;
};

int main(int argc, char **argv)
{
    if (argc != 2)
    {
        printf("Usage: %s <file>\n", argv[0]);
        return 1;
    }

    setvbuf(stdout, NULL, _IONBF, 0);
    setvbuf(stderr, NULL, _IONBF, 0);

    FILE *f = fopen(argv[1], "r");

    if (!f)
    {
        printf("Error opening file %s\n", argv[1]);
        return 1;
    }

    struct action action;

    while (fread(&action, 1, sizeof(action), f))
    {
        switch (action.type)
        {
        case ACTION_READ:
            fwrite(action.address, 1, action.size, stdout);
            break;
        case ACTION_WRITE:
            fread(action.address, 1, action.size, f);
            break;
        default:
            printf("Unknown action %d\n", action.type);
            break;
        }
    }

    fclose(f);

    return 0;
}