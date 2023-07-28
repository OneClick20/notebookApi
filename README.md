Разработка тестового REST API для записной книжки

Документация API в swagger
https://app.swaggerhub.com/apis/adolsh/NoteBook_api/1.0.0

Роуты лежат в файле routes/api.php
Реализован контроллер Controllers/NoteBookController
Работа с БД осуществляется в классе Repositories/NoteBookRepository.php

Инструкция по развертыванию приложения (для Ubuntu):
1)Склонировать проект. В корневом каталоге создать папку data

Дальше все делать из папки src
2)Нужно собрать и запустить контейнеры.
    docker-compose build
    docker-compose up -d
3)Накатить миграцию
    php artisan migrate
4)Чтобы не было проблем сохранием изображений нужно выполнить команды по смене владельца папок
    chown -R www-data:www-data /var/www
    chmod -R g+rw /var/www