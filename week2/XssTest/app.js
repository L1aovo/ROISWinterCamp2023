const express = require('express');
const puppeteer = require('puppeteer');
const bodyParser = require('body-parser');
const path = require('path');
const fs = require('fs');
const ejs = require('ejs');
const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms))
const app = express();
app.use(bodyParser.urlencoded({ extended: true }));
app.use('/public', express.static(path.join(__dirname, 'public')));

app.set('view engine', 'ejs');
app.set('views', path.join(__dirname, 'views'));


app.get('/', (req, res) => {
    res.render('index');
});


app.post('/report', async (req, res) => {
    try {
        const { report } = req.body;
        console.log(report);
        const url = new URL(report);
        if (!url.protocol.startsWith('http') || !url.host.startsWith('localhost:3000')) {
            throw new Error('Invalid URL');
        }
        const browser = await puppeteer.launch({
            args: ['--no-sandbox'],
        });
        const page = await browser.newPage();
        await page.setCookie({
            name: 'FLAG',
            value: 'ROIS{Just_A_Small_X55_Y0u_X_Me~~}',
            domain: "localhost"
        });
        await delay(2000) /// waiting 5 second.
        await page.goto(url.href, { timeout: 1000 });
        await page.screenshot({
            path: 'screenshot/example.png',
            encoding: 'base64'
        });
        let base64Img = await fs.readFileSync(path.join(__dirname, 'screenshot/example.png')).toString();
        await page.close();
        res.render('result', { base64Img });
    } catch (e) {
        res.send(e);
    }
});


app.listen(3000, () => {
    console.log('Server is listening on http://localhost:3000');
})
