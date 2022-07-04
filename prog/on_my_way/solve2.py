import socket
import numpy as np
from math import nan

np.set_printoptions(threshold=np.inf)
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect(("prog.pwnme.fr", 7000))

while True:
    t = s.recv(20480).decode()
    print(t)
    if "Wrong" in t:
        print(final)
        print(n)
        print(cooe)
        print(coos)
        print(taille)
        print(msg)
        break
    args = t.split("\n")
    tableau = []
    for arg in args:
        if arg.replace("0", "").replace("E", "").replace("S", "") == "" and len(arg) != 0:
            tableau.append(arg)
    taille = len(tableau[0])
    print(taille)
    final = np.zeros((taille, taille, taille))
    coos = [-1, -1, -1]
    cooe = [-1, -1, -1]
    for i in range(len(tableau)):
        for j in range(taille):
            if tableau[i][j] == "0":
                value = 0
            elif tableau[i][j] == "E":
                value = 1
                cooe = [int(i/taille), i % taille, j]
            elif tableau[i][j] == "S":
                value = 2
                coos = [int(i/taille), i % taille, j]
            final[int(i/taille), i % taille, j] = value
    # Chall 1
    n = 0
    for i in range(3):
        n += abs(coos[i]-cooe[i])
    msg = str(n) + "\n"

    # Chall 2
    # msg=""

    # if coos[0]>cooe[0]:
    #    msg+=("z"+"+;")*abs(coos[0]-cooe[0])
    # elif coos[0]<cooe[0]:
    #    msg+=("z"+"-;")*abs(coos[0]-cooe[0])

    # if coos[1]>cooe[1]:
    #    msg+=("y"+"-;")*abs(coos[1]-cooe[1])
    # elif coos[1]<cooe[1]:
    #    msg+=("y"+"+;")*abs(coos[1]-cooe[1])

    # if coos[2]>cooe[2]:
    #    msg+=("x"+"+;")*abs(coos[2]-cooe[2])
    # elif coos[2]<cooe[2]:
    #    msg+=("x"+"-;")*abs(coos[2]-cooe[2])

    #msg=msg[:-1] + "\n"

    # print(final)
    # print(msg)
    s.send(msg.encode())
