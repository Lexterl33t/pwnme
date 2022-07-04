from Crypto.Util.number import inverse, long_to_bytes
from sage.all import *
import os

os.chdir(os.path.dirname("PATH_OF_THE_FILE"))
output = open("output.txt","r").read().split("\n")

n = int(output[0].split(" = ")[1])
e = int(output[1].split(" = ")[1])
c = int(output[2].split(" = ")[1])

factors = ecm.factor(n)

phi = 1
for factor in factors:
    phi *= (factor - 1)
    
d = inverse(e, phi)

flag = pow(c, d, n)

print(long_to_bytes(flag))