FROM php:8.1-fpm
RUN docker-php-ext-install pdo_mysql
# install configure file      
  #PHP の設定ファイルである php.ini を作成
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
# settings
  #追加で設定するための PHP 設定ファイルを設置
COPY ./php.ini /usr/local/etc/php/php.ini

#mhsendmailのインストールを追加
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail