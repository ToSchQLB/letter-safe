FROM php:5.6-apache

RUN apt-get update && apt-get -y install tesseract-ocr tesseract-ocr-deu imagemagick poppler-utils

COPY ./ /var/www/html/letter-safe

EXPOSE 80/tcp
