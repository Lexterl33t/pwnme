FROM node:alpine

WORKDIR /usr/app
# run apt install libssl-dev -y
# Install Puppeteer under /node_modules so it's available system-wide
COPY . .
RUN npm install
RUN npm run build
run npm run generate

CMD ["npm", "start"]