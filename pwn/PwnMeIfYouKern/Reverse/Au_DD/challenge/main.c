#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "node.h"

enum Bool {
    false,
    true
};

typedef enum Bool Bool;

Node* initFlag()
{
    Node *node_initialisation = node_init(76);

    node_insert(node_initialisation, 17);
    node_insert(node_initialisation, 78);
    node_insert(node_initialisation, 75);
    node_insert(node_initialisation, 19);
    node_insert(node_initialisation, 68);
    node_insert(node_initialisation, 63);
    node_insert(node_initialisation, 76);
    node_insert(node_initialisation, 17);
    node_insert(node_initialisation, 83);
    node_insert(node_initialisation, 84);
    node_insert(node_initialisation, 63);
    node_insert(node_initialisation, 17);
    node_insert(node_initialisation, 78);
    node_insert(node_initialisation, 63);
    node_insert(node_initialisation, 77);
    node_insert(node_initialisation, 19);
    node_insert(node_initialisation, 77);
    node_insert(node_initialisation, 16);
    node_insert(node_initialisation, 82);
    node_insert(node_initialisation, 89);

    return node_initialisation;
}


Bool isFlag(char *input, Node *list)
{
    char *tmp = input;
    while(*tmp && list) {
        if((list->value) != *(tmp++)-32-32) 
            return false;
        list = list->next;
    }
    return true;
}

int main(int argc, char **argv)
{
    char buffer[21];
    Node *flag_list = initFlag();
    
    printf("Veuillez saisir le flag: ");
    fgets(buffer, 21, stdin);
    if(strlen(buffer) == 20) {
        if(isFlag(buffer, flag_list) == true) {
            printf("Congratulation !!! you Can validate the chall with the flag !!\n");
            return 0;
        } else {
            printf("Incorrect flag !! Try again !!\n");
            return 0;
        }
    } else {
        printf("Incorrect size !!\n");
        return 0;
    }

}