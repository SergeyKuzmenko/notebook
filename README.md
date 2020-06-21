## Описание
Реализация тестового задания:
https://docs.google.com/document/d/1wwQtA9sDFbJ09MWEQNTlckbvtQZrNGu-s9LKa4yR4xg/

## Установка
1. Клонируйте проект
2. Перейдите в созданую директорию и выполните:
`composer install`
3. Создайте файл .env и установите параметры для подключения к базе данных.
4. Выполните `php artisan key:generate`
5. Выполните `php artisan migrate`
6. Если вы хотите заполнить базу данных начальными (фейковыми) данными, выполните: `php artisan db:seed`
7. Готово!