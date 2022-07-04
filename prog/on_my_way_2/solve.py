#!/usr/bin/env python3.10
from pwn import *
r = remote("prog.pwnme.fr", 7001)

def find_element(map, element):
    for xi,x in enumerate(map):
        for yi,y in enumerate(x):
            for zi,z in enumerate(y):
                if z == element:
                    return [xi,yi,zi]
    return False

def get_distance(map):
    E_coords = find_element(map, 'E')
    S_coords = find_element(map, 'S')
    return abs(E_coords[0]-S_coords[0]) + abs(E_coords[1]-S_coords[1]) + abs(E_coords[2]-S_coords[2])

def get_path(map):
    E_coords = find_element(map, 'E')
    S_coords = find_element(map, 'S')
    path = []
    for i in range(abs(E_coords[0]-S_coords[0])):
        if E_coords[0] < S_coords[0]:
            path.append('z+')
        else:
            path.append('z-')
    for i in range(abs(E_coords[1]-S_coords[1])):
        if E_coords[1] > S_coords[1]:
            path.append('y+')
        else:
            path.append('y-')
    for i in range(abs(E_coords[2]-S_coords[2])):
        if E_coords[2] < S_coords[2]:
            path.append('x+')
        else:
            path.append('x-')

    return ';'.join(path)

while True:
    map = []
    z = []
    try:
        for row in r.recvuntil(b">>").decode().split("\n")[:-1]:
            if row == '':
                continue
            if row == '-':
                map.append(z)
                z = []
            else:
                z.append(list(row))
        r.sendline(get_path(map).encode())
    except:
        exit()

    res = r.recvline().decode()
    if 'PWNME' in res:
        print(res)
    