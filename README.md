# USACitizenGuide (учебный проект)

Простейший PHP-проект без фреймворков, точка входа `index.php` в корне.

## Установка на OSPanel

1. Скопируйте весь проект в папку `OSPanel\domains\MyUSAPassport`.
2. Запустите OSPanel.
3. В phpMyAdmin создайте базу и залейте `database.sql`.
4. При необходимости отредактируйте параметры подключения в `config/config.php`.
5. Откройте сайт по адресу `http://myusapassport/` (или как настроен домен в OSPanel).

## Что реализовано

- Простая маршрутизация через параметр `route` в `index.php`.
- Несколько базовых страниц (главная, способы, документы, обратная связь).
- SQL-схема с таблицами users, articles, categories, faq, news, checklists, inquiries.

Дальше можно постепенно дописывать авторизацию, личный кабинет, админку и т.п.




РЕФЕРЕНС: https://mircare.com/ru-ru/blog/kak-poluchit-grazhdanstvo-v-ssha