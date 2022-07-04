from Crypto.Util.number import *

output = open("output.txt","r").read().split("\n")

n1 = int(output[0].split(" = ")[1])
n2 = int(output[1].split(" = ")[1])
e = int(output[2].split(" = ")[1])
c1 = int(output[3].split(" = ")[1])
c2 = int(output[4].split(" = ")[1])

p = GCD(n1,n2)

q1 = n1//p
q2 = n2//p

d1 = inverse(e, (p-1)*(q1-1))
d2 = inverse(e, (p-1)*(q2-1))

m1 = pow(c1, d1, n1)
m2 = pow(c2, d2, n2)

print(long_to_bytes(int(str(m1))) + long_to_bytes(int(str(m2))))