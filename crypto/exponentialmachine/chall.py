from Crypto.Util.number import *

LIMIT = 0
TRY = 64

a = getPrime(512)
x = bytes_to_long(open("./flag.txt", "r").read().encode())
n = getPrime(512)

print("You can have the result of whatever operation between multiplication, exponentiation, addition, division and substraction !")
print(
    f"Also you can choose the value with which you can apply the operation. You have only {TRY} attempts to retrieve the flag.\n")

print("a =", a)
print("x = ?")
print("n =", n)

print("(a**x) % n =", str(pow(a, x, n)), "\n")

while LIMIT < TRY:
    operation = input(
        "[+] Give me the operation you want to make and I'll give you the result : ")

    try:
        value = int(
            input("[+] Give me the value of the number after your operation : "))

    except ValueError:
        print("You can only enter numbers !\n")
        break

    if operation not in ["/", "+", "-", "*", "**"]:
        print("You are only allowed to use these operations : /, *, +, -, **\n")
        break

    elif operation == "/":
        result = pow(a, (x // value), n)

    elif operation == "*":
        result = pow(a, (x * value), n)

    elif operation == "+":
        result = pow(a, (x + value), n)

    elif operation == "-":
        result = pow(a, (x - value), n)

    elif operation == "**":
        result = pow(a, (x ** value), n)

    LIMIT += 1

    print("Result :", result, "\n")
