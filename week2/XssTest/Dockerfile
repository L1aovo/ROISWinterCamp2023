FROM node:14-alpine

# 创建用户以避免使用root权限运行chrome
RUN addgroup -S pptruser && adduser -S -g pptruser pptruser \
    && mkdir -p /home/pptruser/Downloads \
    && chown -R pptruser:pptruser /home/pptruser

# 安装 chrome
RUN apk update \
    && apk add --no-cache \
    chromium \
    nss \
    freetype \
    freetype-dev \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
    nodejs \
    yarn

# 设置环境变量
ENV PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium-browser
ENV PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true

# 设置工作目录
WORKDIR /app

# 安装依赖
RUN npm --registry https://registry.npm.taobao.org install puppeteer \
    && npm --registry https://registry.npm.taobao.org install express \
    && npm --registry https://registry.npm.taobao.org install ejs

# 添加源代码
COPY . .

# 添加文件夹权限
RUN chmod -R 777 /app/screenshot

# 使用非root用户运行
USER pptruser

# 启动应用程序
CMD ["node", "app.js"]

