FROM composer as builder

WORKDIR /usr/farleyrs/projeto_bovino
COPY composer.* ./
RUN composer update --no-interaction

FROM php:8.1.0

RUN apt update && apt upgrade -y
RUN apt install zip unzip zlib1g-dev libzip-dev netcat -y
RUN docker-php-ext-install pdo pdo_mysql zip

RUN curl "https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh" -o setup.deb.sh && \
  chmod +x ./setup.deb.sh && ./setup.deb.sh && apt install symfony-cli -y && rm -f ./setup.deb.sh

WORKDIR /usr/farleyrs/projeto_bovino

COPY . .
RUN rm -f Dockerfile

COPY --from=builder /usr/farleyrs/projeto_bovino/vendor /usr/farleyrs/projeto_bovino/vendor

RUN curl -s -o /usr/bin/wait-for "https://raw.githubusercontent.com/eficode/wait-for/v2.2.3/wait-for" && \
  chmod +x /usr/bin/wait-for

EXPOSE 8000

