from string import digits


FLAG_ENCRYPTED = [99,101,127,129,122,77,107,7,73,83,118,124,19,77,16,127,124,17,111,131,85,23,121,27,146,28,119,105]


def decrypt(array, secret):
    return ''.join(chr(((v[0]-i) ^ ord(v[1]))) for i, v in enumerate(zip(array, secret)))


for c in digits:
    secret = c*100
    res = decrypt(FLAG_ENCRYPTED, secret)
    if 'PWNME' in res:
        print(res)
