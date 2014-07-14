<?php
$_['start_title'] = 'Проверка директорий :';
$_['chmod_log_true'] = '<font color="green">готово к (чтению/записи)</font>';
$_['chmod_log_false'] = '<font color="red">нет прав к (чтению/записи)</font>';
$_['chmod_cache_true'] = '<font color="green">готово к (чтению/записи)</font>';
$_['chmod_cache_false'] = '<font color="red">нет прав к (чтению/записи)</font>';
$_['chmod_conf_true'] = '<font color="green">готово к (чтению/записи)</font>';
$_['chmod_conf_false'] = '<font color="red">нет прав к (чтению/записи)</font>';

$_['os_linux'] = 'Если у вас ОС linux ubuntu то зайдите в каталог /папка панели/system/install/tools/'."\n"
                 .'Там увидите файл chmod_linux_ubuntu.sh поместите его в папку панели и запустите через терминал и обновите браузер'."\n";

$_['chmod_error'] = '<font color="red">Директории не доступны для записи Установка не вазможна!</font>'."\n"
                 .'Установите права на:'."\n"
                 .'/system/log: 777'."\n"
                 .'/system/cache: 777'."\n"
                 .'/system/config: 777'."\n"
                 .'и обновите браузер '."\n\n";

$_['btn_continue'] = 'Далее';
$_['btn_back'] = 'Назад';
$_['btn_load'] = 'Готово';
$_['btn_update'] = 'Обновить';
$_['conf_site_title'] = 'Конфигурация сайта:';
$_['conf_siteDB_title'] = 'Конфигурация базы сайта';
$_['confDB_host'] = 'Хост базы';
$_['confDB_user'] = 'Логин базы';
$_['confDB_pass'] = 'Пароль базы';
$_['confDB_port'] = 'Порт базы';
$_['confDB_base'] = 'Название базы';
$_['confDB_driver'] = 'Драйвер для работы с базой';
$_['confDB_ecod'] = 'Кадировка вывода из базы';
$_['confDB_pref'] = 'Префикс таблиц';
$_['confDB_info'] = 'Внимание! </br> Обезательно заполните поля: Хост,логин,пароль,порт базы! </br> Если вы не понимаете что вам нужно еще заполнить то тогда не трогайте остальные поля! Остальное заполнится само так как там написано.</br> База сама создается с тем именем каторое указано в поле "Название базы"';
$_['confDB_connect'] = 'Тест : <font color="green">Соединение установлено</font></br>';
$_['confDB_connect_error'] = 'Тест : <font color="red">Соединение не установлено!</font></br>';
$_['confDB_createDB'] = '<font color="green">База создана</font></br>';
$_['confDB_createDB_false'] = '<font color="red">Не удалось создать базу</font></br>';
$_['confDB_file'] = '<font color="green">Фаил конфигурации базы сайта создан</font></br>';
$_['confDB_file_false'] = '<font color="red">Фаил конфигурации базы сайта не создан</font></br>';
$_['confDB_input'] = '<font color="red">Поля не заполнены</font></br>';
$_['conf_server_title'] = 'Конфигурация сервера';
$_['conf_server_name'] = 'Сервер';
$_['conf_server_DB'] = 'База сервера';
$_['conf_server_vote'] = 'Настройка Голосов';
$_['conf_server_soap'] = 'Soap Клиент';
$_['confSV_ID'] = 'id номер сервера в базе "auth" таблице "realmlist"';
$_['confSV_auth'] = 'База аккаунтов';
$_['confSV_characters'] = 'База персонажей';
$_['confSV_world'] = 'База мира';
$_['confSV_vote'] = 'Стоимость простого голоса';
$_['confSV_sms'] = 'Стоимость sms голоса';
$_['confSV_file'] = 'Ссылка на фаил сервера в mmotop';
$_['confSV_soap_host'] = 'Хост Soap';
$_['confSV_soap_port'] = 'Порт Soap';
$_['confSV_soap_login'] = 'Логин GM LVL 3';
$_['confSV_soap_pass'] = 'Пароль GM LVL 3';
$_['confSV_soap_send_title'] = 'Заголовок сообщения';
$_['confSV_soap_send_text'] = 'Текст сообщения';
$_['confSV_message'] = 'Внимание! </br> Все поля должны быть заполнены! </br> База сервера должна быть доступна! </br>Для создания еще одной или более конфигураций для других серверов просто заполните заново. </br>';
$_['formSV_input'] = '<font color="red">Не все заполнено!</font></br>';
$_['formSV_select'] = '<font color="red">Данные с сервера не получены!</font></br>';
$_['formSV_build'] = '<font color="red">Нет подходящей базы предметов для :</font>';
$_['formSV_file'] = '<font color="green">Конфигурация сервера создана :</font>';
$_['formSV_file_false'] = '<font color="red">Конфигурация не сервера создана :</font>';
$_['CRtable_title'] = 'Установка таблиц базы';
$_['CRtable_Complete'] = '<font color="green">Таблицы утановлены</font>';
$_['CRtable_vote_table'] = '<font color="red">Фаил с таблицами базы сайта не найден!</font></br>';
$_['CRtable_vote_table_create'] = '<font color="green">Таблицы базы  установлены</font></br>';
$_['CRtable_items_table'] = '<font color="red">Папки с фаилами базы мредметов не найдены!</font></br>';
$_['CRtable_items_table_false'] = '<font color="red">Фаил с таблицами базы Предметов не найден!</font>';
$_['CRtable_items_table_create'] = '<font color="green">Фаил с таблицами базы Предметов установлен</font>';
$_['CRtable_insert_null'] = '<font color="red">Фаил пустой!</font>';
$_['CRtable_insert_insert'] = '<font color="green">Фаил с свойставми предметов залит</font>';
$_['CRtable_items_table_files'] = '<font color="red">Нет фаилов ".sql" в директории </font>';
$_['CAcc_title'] = 'Создание аккаунта';
$_['CAcc_admin'] = 'Придумайте пароль для админки';
$_['CAcc_input_adm'] = 'Поле "Придумайте пароль для админки" Не заполнено!';
$_['ACcc_success'] = '<font color="green">Аккаунт создан</font>';
$_['ACcc_msg_txt'] = 'Внимание! </br> База сервера должна быть доступна! </br> Логин входа в админку будет тот же что и аккаунта.';
$_['End_title'] = 'Последние приготовления';
$_['End_continue'] = '<font color="green">Последняя подгатовка прошла успешно нажмите готово</font>';
$_['End_error'] = '<font color="red">Произошла ошибка замены Фаила!</font>';

