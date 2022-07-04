#pragma once

typedef struct Node Node;

struct Node {
  char value;
  Node *next;
  Node *previous;
};

Node *node_init(char value);
void node_insert(Node *last, char value);
void node_print(Node *node);
int node_size(Node *node);
void node_delete(Node *element);
Node *node_get(Node *node, int index);