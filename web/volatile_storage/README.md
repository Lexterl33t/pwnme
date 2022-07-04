# Volatile Storage - easy

You just found a website with a new concept: do not store anything in a database, and do not let user to chose their password.

All stored data are volatile, and will be cleaned everyday.

To register an account, you just have to put a username, and the website will generate you a password according to your username.
Once an account is create, the username is locked for you, so you will be the only one to access your data


Find how the website generate passwords, and take over **admin** account to view all his secrets

# Solution

You have to guess the way the password is generated.

Example, with `test` user:

Generated password is `NDYyMWQzNzNjYWRlNGU4Mw==`

It looks like base64. After a decode, we obtain `4621d373cade4e83`

It seems to be a hash. But it's way to short to be a real hash.

Guessy part:

if we get the md5 of `test`, we obtain `098f6bcd4621d373cade4e832627b4f6`

In the middle of the hash, we can see our previously found hash: `098f6bcd 4621d373cade4e83 2627b4f6`

Just reverse this process, with 'admin' account, to access his session !

admin md5: `21232f297a57a5a743894a0e4a801fc3`

password = base64(7a57a5a743894a0e) = `N2E1N2E1YTc0Mzg5NGEwZQ==`
