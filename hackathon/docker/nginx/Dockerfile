FROM nginx:1.14-alpine

COPY ssl/server.crt /etc/ssl/certs/server.crt
COPY ssl/server.key /etc/ssl/certs/server.key

ADD default.conf /etc/nginx/conf.d/default.conf
