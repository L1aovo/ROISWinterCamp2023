FROM php:7.4-apache

RUN rm -rf /var/www/html
COPY src /var/www/html
RUN chmod -R 755 /var/www/html
COPY flag /flag

COPY readflag.c /readflag.c

RUN chmod 0600 /flag && \
    gcc /readflag.c -o /readflag  && \
    chmod u+s /readflag && \
    rm /readflag.c && \
    chmod -R 755 /var/www/html