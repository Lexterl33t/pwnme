const puppeteer = require("puppeteer");
const express = require("express");
const app = express();
const port = 3000;

const messages = [
  "Wtf are those colors ?",
  "You have terrible taste",
  "There is nothing original with your bike",
  "Who's gonna buy a bike like that.. ?",
  "Do you have any idea what a bike is supposed to look like ?",
  "Ew, I wouldn't be caught dead on that thing 🤢",
  "It would work if I was blind",
  "Alright, that's.. special..",
  "Yeah, that's one way to do it...",
  "Aaaannd, that's a no. Definitely a no",
  "Would you be serious for 1 second ?",
  "Why would you do that to me ? Did I ever been mean to you ?",
  "I almost made the mistake to send it into production",
];

// const host = 'http://localhost:8081'
const host = "http://pmb";

let browser;
app.get("/bike/:id", async (req, res) => {
  await fetchCustom(
    `${host}/?page=preview&id=${req.params.id}&action=viewBike`
  );
  res.send(
    `Bike ${req.params.id} has been reviewed ! Message from admin: ${
      messages[Math.floor(Math.random() * messages.length)]
    }`
  );
});

async function start() {
  console.log("Starting browser...");
  browser = await puppeteer.launch({
    // "headless": false,
    args: [
      // Required for Docker version of Puppeteer
      "--no-sandbox",
      "--disable-setuid-sandbox",
      // This will write shared memory files into /tmp instead of /dev/shm,
      // because Docker’s default for /dev/shm is 64MB
      "--disable-dev-shm-usage",
    ],
  });
  let loginPage = await browser.newPage();
  console.log(`goto: ${host}/?page=login`);
  await loginPage.goto(`${host}/?page=login`, {
    timeout: 0,
    waitUntil: "domcontentloaded",
  });
  await loginPage.type("input[name=pseudo]", "admin");
  await loginPage.type(
    "input[name=password]",
    "Th4re_1s_a_Pr0bl3m_1f_u_f0und_M3"
  );
  // await loginPage.type('input[name=pseudo]', 'root');
  // await loginPage.type('input[name=password]', 'root');
  await loginPage.type("input[name=remember]", "on");
  await loginPage.evaluate(() => {
    document.querySelector("button[type=submit]").click();
  });
  console.log("cookie admin:", (await loginPage.cookies())[0].value);
  await loginPage.close();
  return true;
}

async function fetchCustom(url) {
  let page = await browser.newPage();
  console.log("fetch page...", url);
  await page.goto(url, { timeout: 0 });
  console.log("fetched!", url);
  await sleep(3);
  page.close();
  return true;
}

function sleep(s) {
  return new Promise((resolve) => {
    setTimeout(resolve, s * 1000);
  });
}

start().then(() => {
  app.listen(port, () => {
    console.log(`Bot listening on port ${port}`);
  });
});
