const express = require("express");
const md5 = require("md5");
var jwt = require("jsonwebtoken");
const cookieParser = require("cookie-parser");
var htmlencode = require("htmlencode");

const app = express();
const port = 3000;

const JWT_SECRET = "S3ecretCUSTOMNOONEWILLFINDITIHOPE";

let users = [
  {
    username: "admin",
    secrets: [{ name: "Flag", value: process.env.FLAG_VOLATILE || "FLAG" }],
    password: getPasswordForUser("admin"),
  },
];

app.set("views", "./views");
app.set("view engine", "ejs");
app.use(express.static(__dirname + "/public"));
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(cookieParser());

app.get("/", (req, res) => {
  res.render("index", { message: "Hello there!" });
});

app.get("/logout", (req, res) => {
  res.cookie("jwt", "", { maxAge: 0 });
  res.redirect("/");
});

app.get("/storage", (req, res) => {
  let token = req.cookies["jwt"];

  if (!token) {
    res.status(401).json({ err: "No token" });
    return;
  }

  try {
    const decodedToken = jwt.verify(token, JWT_SECRET);
    if (decodedToken) {
      let user = users.find((u) => u.username === decodedToken.username);
      if (!user) {
        res.status(401).json({ err: "Username doesn't exists" });
      } else {
        res.render("storage", {
          username: htmlencode.htmlEncode(user.username),
          secrets: user.secrets,
          password: user.password,
        });
      }
    } else {
      res.status(401).json({ err: "Invalid token" });
    }
  } catch (error) {
    res.status(401).json({ err: error.message });
  }
});

app.post("/secret", (req, res) => {
  let name = req.body.name;
  let value = req.body.value;

  if (!name || !value) {
    res.status(401).json({ err: "Missing secret parameters" });
    return;
  }

  let token = req.cookies["jwt"];

  if (!token) {
    res.status(401).json({ err: "No token" });
    return;
  }

  try {
    const decodedToken = jwt.verify(token, JWT_SECRET);
    if (decodedToken) {
      if (decodedToken.username === "admin") {
        res.status(401).json({ err: "You can't modify admin secrets" });
        return;
      }
      let user = users.find((u) => u.username === decodedToken.username);
      if (!user) {
        res.status(401).json({ err: "Username doesn't exists" });
      } else {
        user.secrets.push({ name, value });
        res.redirect("/storage");
      }
    } else {
      res.status(401).json({ err: "Invalid token" });
    }
  } catch (error) {
    res.status(401).json({ err: error.message });
  }
});

app.post("/login", (req, res) => {
  let username = req.body.username;
  let password = req.body.password;

  if (!password || !username) {
    res.json({
      err: "Missing parameters",
    });
    return;
  }

  if (!users.find((u) => u.username === username)) {
    res.json({
      err: "Account not registered",
    });
    return;
  }

  if (getPasswordForUser(username) === password) {
    token = jwt.sign({ username }, JWT_SECRET, { expiresIn: "3h" });
    res.cookie("jwt", token);
    res.redirect("/storage");
  } else {
    res.status(401).json({
      err: "Invalid password",
    });
  }
});

app.post("/register", (req, res) => {
  let username = req.body.username;
  if (!username) {
    res.status(401).json({
      err: "Missing username",
    });
    return;
  }
  if (users.find((u) => u.username === username)) {
    res.status(401).json({
      err: "Account already registered. Login with the password you get on your registration !",
    });
    return;
  }
  users.push({
    username,
    secrets: [],
    password: getPasswordForUser(username),
  });
  token = jwt.sign({ username }, JWT_SECRET, { expiresIn: "3h" });
  res.cookie("jwt", token);
  res.redirect("/storage");
});

app.listen(port, () => {
  console.log(`App listening on port ${port}`);
});

function getPasswordForUser(user) {
  let data = md5(user);
  data = data.slice(8, 32 - 8);
  let buff = Buffer.from(data);
  return buff.toString("base64");
}
