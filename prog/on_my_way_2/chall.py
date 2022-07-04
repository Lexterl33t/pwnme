#!/usr/bin/env python3.10
import random

FLAG = open("./flag.txt", "r").read()

n = 16

for i in range(n):
    size = i + 2
    map = [[[0 for k in range(size)] for j in range(size)]
            for i in range(size)]

    E_coords = [random.randint(0, size-1),random.randint(0, size-1),random.randint(0, size-1)]

    map[E_coords[0]][E_coords[1]][E_coords[2]] = 'E'

    S_coords = [random.randint(0, size-1),random.randint(0, size-1),random.randint(0, size-1)]
    while(S_coords == E_coords):
        S_coords = [random.randint(0, size-1),random.randint(0, size-1),random.randint(0, size-1)]
    
    map[S_coords[0]][S_coords[1]][S_coords[2]] = 'S'

    for x in map:
        for y in x:
            print('')
            for z in y:
                print(z, end="")
        print('\n-', end="")
    print('\n')

    distance = abs(E_coords[0]-S_coords[0]) + abs(E_coords[1]-S_coords[1]) + abs(E_coords[2]-S_coords[2])
    
    player_input = input("Answer >> ").strip()
    
    path = player_input.split(";")
    if len(path) < 1:
        print("Wrong inputs")
        exit()
    try:
        for way in path:
            axe = way[0]
            dir = way[1]
            if axe == 'x':
                axe_int = 2
                if dir == '+':
                    E_coords[axe_int] += 1
                elif dir == '-':
                    E_coords[axe_int] -= 1
                else:
                    raise Exception(dir)
            elif axe == 'y':
                axe_int = 1
                if dir == '+':
                    E_coords[axe_int] -= 1
                elif dir == '-':
                    E_coords[axe_int] += 1
                else:
                    raise Exception(dir)
            elif axe == 'z':
                axe_int = 0
                if dir == '+':
                    E_coords[axe_int] += 1
                elif dir == '-':
                    E_coords[axe_int] -= 1
                else:
                    raise Exception(dir)
            else:
                raise Exception(axe)

            
    except:
        print("Wrong inputs")
        exit()
    if E_coords != S_coords:
        print("Wrong answer")
        exit()

print("Congratz ! Here is your flag: ", FLAG)