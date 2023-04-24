FROM nginx:stable-alpine

ARG PROJECT_ROOT

COPY .docker/nginx/sites/image.conf /etc/nginx/conf.d/

RUN sed -i "s|%root%|$PROJECT_ROOT|g" /etc/nginx/conf.d/image.conf
