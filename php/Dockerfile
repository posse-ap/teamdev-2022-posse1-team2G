FROM php:8.1-fpm
RUN docker-php-ext-install pdo_mysql

CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci", "--default-time-zone = 'Asia/Tokyo'"]
CMD ["mysql", "--default-character-set=utf8"]
CMD ["client", "--default-character-set=utf8"]docker