# On My Way 1/3

For this challenge, you'll have to find the exit point, from a start position, in a 3D map.

`prog.pwnme.fr 7000`

## Map representation

Example for a map, with a size of n=2

Server will send you this:
```
0E
00
-
00
S0
-
```

axes:

```
layer z0    layer z1
^         ^  
|  0E     | 00 
|  00     | S0 
y         y  
 x---->    x---->
```


coords(E) : x=1 y=1 z=0

coords(S) : x=0 y=0 z=1

The shortest path that solve this map is wrote like:


z+;y-;x-

z+ => Go from z0 to z1

y- => Go from y1 to y0

x- => Go from x1 to x0

For this challenge, you just have to find the minimal distance to go from the (S)tart to the (E)nd

In this example, answer will be `3`