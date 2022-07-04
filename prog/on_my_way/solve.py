#!/usr/bin/env python3.10
from pwn import *
r = remote("prog.pwnme.fr", 7000)

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
        r.sendline(str(get_distance(map)).encode())
    except:
        exit()

    res = r.recvline().decode()
    if 'PWNME' in res:
        print(res)