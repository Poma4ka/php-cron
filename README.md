# php-cron

Простой класс для выполнения cron команд. Для работы нужно добавить в cron задачу "* * * * * php /path_to_cron_file.php"

## Использование:

Для выставления таймзоны выполняется команда:
```php
cron::setTimezone("Europe/Moscow");
```

Для выполнения задачи выполняется:
```php
cron::job("* * * * *",function () {
    any code...
});
```
