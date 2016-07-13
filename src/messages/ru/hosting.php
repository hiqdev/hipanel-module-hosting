<?php

/*
 * Hosting Plugin for HiPanel
 *
 * @link      https://github.com/hiqdev/hipanel-module-hosting
 * @package   hipanel-module-hosting
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

return [
    'Hosting' => 'Хостинг',
/**
 * Account
 */
    'Accounts' => 'Аккаунты',
    'Block account' => 'Заблокировать акканут',
    'Confirm account blocking' => 'Подтвердите блокировку аккаунта',
    'This will immediately terminate SSH sessions and reject new SSH and FTP connections!' => 'Это приведет к немедленному разрыву активных SSH соединений и запретит установку новых SSH или FTP соединений!',
    'Unblock account' => 'Разблокировать аккаунт',
    'Confirm account unblocking' => 'Подтвердите разблокировку аккаунта',
    'Access to the account is opened by default. Please input the IPs, for which the access to the server will be granted' => 'Доступ к аккаунту открыт по умолчанию. Пожалуйста, введите IP-адреса, для которых доступ к серверу будет предоставлен',
    'IP restrictions' => 'Ограничения по IP',
    'Create FTP account' => 'Создать FTP аккаунт',
    'Create account' => 'Создать аккаунт',
    'account mail config' => 'найстройки почты аккаунта',
    'Mail config' => 'Настройки почты',
    'Account creating task has been added to queue' => 'Задача создания аккаунта была добавлена в очередь',
    'Account deleting task has been added to queue' => 'Задача удаления аккаунта записи была добавлена в очередь',
    'Account detailed information' => 'Подробная информация о аккаунте',
    'Account information' => 'Информация об аккаунте',
    'Confirm account deleting' => 'Подтвердите удаление аккаунта',
    'Are you sure you want to delete account {name}? You will loose all data, that relates this account!' => 'Вы уверены, что хотите удалить аккаунт {name}? Вы потеряете все данные, что связаны с ним!',
    'Enter mail settings' => 'Введите настройки почты',
    'Mail settings' => 'Настройки почты',
    'This will immediately terminate all sessions of the user!' => 'Это немедленно прервет все сеансы пользователя!',
    'Enter new restrictions' => 'Введите новые ограничения',
    'Enter a new password' => 'Введите новый пароль',
    'Affected accounts' => 'Аккаунты',
    'Block accounts' => 'Заблокировать аккаунты',
    'Unblock accounts' => 'Разблокировать аккаунты',
    'Manage IP restrictions' => 'Управление ограничением по IP',
    'Maximum letters per hour' => 'Максимум писем в час',
    'New' => 'Новый',
    'Ok' => 'ОК',
    'Blocked' => 'Заблокирован',
    'Deleted' => 'Удалён',
    'Disabled' => 'Отключён',
    'User account' => 'Обычный',
    'FTP-only account' => 'FTP аккаунт',
    'System account' => 'Системный аккаунт',
    'An error occurred when trying to create account' => 'Ошибка при создании аккаунта',
    'Password has been changed' => 'Пароль был изменен',
    'Allowed IPs changing task has been successfully added to queue' => 'Задача изменения списска разрешенных IP адресов была добавлена в очередь',
    'An error occurred when trying to change allowed IPs' => 'Ошибка при изменении разрешенных IP адресов',
    'Mail settings where changed' => 'Настройки почты были изменены',
    'An error occurred when trying to change mail settings' => 'Ошибка при изменении настроек почты',
    'Account was blocked successfully' => 'Аккаунт был заблокирован',
    'Error during the account blocking' => 'Ошибка при блокировании аккаунта',
    'Account was unblocked successfully' => 'Аккаунт был разблокирован',
    'Error during the account unblocking' => 'Ошибка при разблокировании аккаунта',
    'An error occurred when trying to delete account' => 'Ошибка при удалении аккаунта',
    'Hosting accounts were unblocked successfully' => 'Аккаунты были разблокированы',
    'Error during the hosting accounts unblocking' => 'Ошибка при разблокировании аккаунтов',
    'Error during the hosting accounts blocking' => 'Ошибка при блокировании аккаунтов',
    'Hosting accounts were blocked successfully' => 'Аккаунты были заблокированы',

/**
 * Service
 */
    'Soft' => 'ПО',
    'Services' => 'Сервисы',
    'Create service' => 'Создать сервис',
    'Object' => 'Объект',
    'Actions' => 'Действия',
    'Update service' => 'Редактирование сервиса',
    'Service was updated successfully' => 'Сервис был успешно отредактирован',
    'An error occurred when trying to update a service' => 'Произошла ошибка при редактировании сервиса',
    'Service was created successfully' => 'Сервис был успешно создан',
    'An error occurred when trying to create a service' => 'Произошла ошибка при создании сервиса',
    'Service information' => 'Информация о сервисе',
/**
 * DB
 */
    'Database' => 'База данных',
    'Databases' => 'Базы данных',
    'Create DB' => 'Создать БД',
/**
 * IP
 */
    'IP addresses' => 'IP адреса',
    'Create IP' => 'Создать IP',
    'Count of objects' => 'Количество объектов',
    'Single' => 'Единичный',
    'Normalized IP' => 'Нормализированный IP',
    'Expanded IPs' => 'Развернутые IP',
    'Servers' => 'Сервера',
    'Tags' => 'Теги',
    'Tag' => 'Тег',
    'Counters' => 'Счетчики',
    'Links' => 'Связи',
    'Expand' => 'Развернуть',
/**
 * Domains
 */
    'Block domain' => 'Блокировать домен',
    'Domain' => 'Домен',
    'Domains' => 'Домены',
    '{0, plural, one{domain} other{domains}}' => '{0, plural, one{домен} few{домена} many{доменов} other{доменов}}',
    'Temporary' => 'Временный',
    'Proxy enabled' => 'Проксирование',
    'Path' => 'Путь',
    'Go to site {link}' => 'Перейти на сайт {link}',
    'This option will automatically create A records for this domain and its\' aliases. Changes will be uploaded to the NS servers immediately' => 'Эта опция создаст A записи для домена и его алиасов. Изменения будут немедленно загружены на NS серверы',
    'DNS is enabled' => 'DNS включён',
    'Advanced settings were updated successfully' => 'Расширенные настройки были успешно изменеы',
    'Error when updating advanced settings' => 'Ошибка при изменении расширенных настроек',
    'Domain proxy setting settings were changed' => 'Настройки проксирования домена изменеы',
    'Error when changing domain proxy settings' => 'Ошибка при изменении настроек проксирования',
    'hosting domain advanced config' => 'Расширенная конфигурация хостинг домена',
    'Advanced config' => 'Расширенная конфигурация',
    'Hosting domain proxy settings' => 'Настройки проксирования хостингового домена',


    /**
 * Mailboxes
 */
    'Mailbox' => 'Почтовый ящик',
    'Mailboxes' => 'Почтовые ящики',
    'Create mailbox' => 'Создать ящик',
    'Forward only' => 'Только пересылка',
    'Mailbox with forwards' => 'Почтовый ящик с пересылкой',
    'You can not login to this mailbox, but all messages will be forwarded to specified addresses' => 'Вы не можете войти в этот почтовый ящик, все сообщения пересылаются на указанный адрес',
    'You can login this mailbox, also all the messages will be forwarded to specified addresses' => 'В почтовый ящик можно войти, вся почта пересылается на указанный адрес',
    'You can login this mailbox' => 'Вы можете войти в этот почтовый ящик',
    'Password change is prohibited on forward-only mailboxes' => 'Смена пароля невозможна, так как этот адрес используется только для пересылки',
    'Leave this field empty to create a forward-only mailbox' => 'Не заполняйте это поле, если вам ящик нужен только для пересылки',
    'Fill this field only if you want to change the password' => 'Заполните это поле, только если хотите сменить пароль',
    'Mailbox creating task has been added to queue' => 'Задача создания почтового ящика была добавлена в очередь',
    'An error occurred when trying to create mailbox' => 'Произошла ошибка при попытке создать почтовый ящик',
    'Mailbox updating task has been added to queue' => 'Задача редактирования почтового ящика была добавлена в очередь',
    'An error occurred when trying to update mailbox' => 'Произошла ошибка при попытке отредактировать почтовый ящик',
    'Mailbox password change task has been added to queue' => 'Задача смены пароля почтового ящика была добавлена в очередь',
    'An error occurred when trying to change mailbox password' => 'Произошла ошибка при попытке сменить пароль почтового ящика',
    'Mailbox delete task has been created successfully' => 'Задача удаления почтового ящика была добавлена в очередь',
    'An error occurred when trying to delete mailbox' => 'Произошла ошибка при попытке удалить почтовый ящик',
    'All messages will be forwarded on the specified addresses. You can select email from the list of existing or wright down your own.' => 'Все письма будут перенаправлены на указанные адреса. Вы можете выбрать email из списка существующих, или вписать нужный адрес самостоятельно.',

/**
 * Backups
 */
    'Backups' => 'Бэкапы',
    'Backup' => 'Бэкап',
    'Show backups' => 'Показать бэкапы',
    'Backup settings' => 'Настройки бэкапов',
    'Size' => 'Объем',
    'Periodicity' => 'Периодичность',
    'Last backup' => 'Последняя копия',
    'Disk usage' => 'Использование диска',
    'Backup: {0} {1}' => 'Бэкап: {0} {1}',
    'domain' => 'домен',
    'database' => 'база данных',
    'Enable backup' => 'Включить бэкапы',
    'Backup is not enabled' => 'Бэкапы не включены',
/**
 * Crons
 */
    'Crons' => 'Планировщик задач',
    '{0, plural, one{# record} other{# records}}' => '{0, plural, one{# запись} few{# записи} other{# записей}}',
/**
 * Requests
 */
    'Requests' => 'Запросы',
    'Object Name' => 'Имя объекта',
    'Action' => 'Действие',
    'In progress' => 'Выполняется',
    'Done' => 'Завершен',
    'Error' => 'Ошибка',
    'Buzzed' => 'Отложен',
    'Server' => 'Сервер',
    'Service' => 'Сервис',

];
