<?php
/**
 * Этот файл является частью модуля веб-приложения GearMagic.
 * 
 * Пакет русской локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'Установщик',
    '{description}' => 'Установка редакции веб-приложения',
    '{permissions}' => [],

    // Setup
    'Setup' => 'Установка',
    'edition' => 'редакция',
    'You need to fill in the field "%s"' => 'Вам необходимо заполнить поле "%s".',
    'Attention!' => 'Внимание!',
    'required fields' => 'обязательные поля для заполнения',
    'Error' => 'Ошибка',
    'Warning' => 'Предупреждение',
    'characters must be more than %s but less than %s' => 'символов должно быть больше %s, но меньше %s',
    'characters must be more than %s' => 'символов должно быть больше %s',
    'characters must not exceed %s' => 'символов не должно быть больше %s', 
    'The field "%s" must have no more than %s but less than %s characters' => 'Поле "<b>%s</b>" должно иметь не больше <b>%s</b>, но и не меньше <b>%s</b> символов.',
    'The field "%s" must have at least %s characters' => 'Поле "<b>%s</b>" должно иметь не меньше <b>%s</b> символов.',
    'The field "%s" must have no more than %s characters' => 'Поле "<b>%s</b>" должно иметь не больше <b>%s</b> символов.',
    
    // Setup: макет страницы
    'Welcome' => 'Добро пожаловать',
    'Registration' => 'Регистрация',
    'Check' => 'Проверка',
    'Setup selection' => 'Выбор установки',
    'Database selection' => 'Выбор базы данных',
    'Back' => 'Назад',
    'Next' => 'Далее',
    'Check connection' => 'Проверить подключение',

    // 404: макет страницы
    'Web application installer' => 'Установщик веб-приложения',
    'install' => 'установить',
    'To install the web application follow the link %s' => 'Для установки веб-приложения перейдите по ссылке %s',
    'If you don\'t need an installer or the web application is already installed then remove the directory "%s"' 
        => 'Если вы не нуждаетесь в установщике или веб-приложение уже установлено, тогда удалите каталог "%s"',

    // CommonChoice\StepWelcome: макет страницы
    'Welcome to the GearMagic installation' => 'Добро пожаловать в установку GearMagic',
    'You will be guided through the entire installation process' => 'Вы пройдёте через весь процесс установки',
    'Please click the «Next» button to continue' => 'Пожалуйста, нажмите кнопку «Далее» для продолжения',
    'Choose language' => 'Выберите язык',
    // CommonChoice\StepWelcome: сообщения
    'You need to select a language' => 'Вам необходимо выбрать язык',

    // CommonChoice\StepCheck: макет страницы
    'Preliminary check' => 'Предварительная проверка',
    'Your web application must meet the required parameters' 
        => 'Ваше веб-приложение должно соответствовать обязательным параметрам',
    'If one of the parameters is highlighted in red, then you need to fix it' 
        => 'Если один из параметров выделенный красным цветом, то вам необходимо его исправить',
    'If you continue with the installation without patching, your web application may be broken' 
        => 'Если вы продолжаете установку без исправления, то работоспособность вашего веб-приложения возможно будет нарушена',
    'Installed' => 'Установлен',
    'Not installed' => 'Не установлен',
    'Not loaded' => 'Выключен',
    'Loaded' => 'Включен',
    'Parameter' => 'Параметр',
    'Required' => 'Требуется',
    'Current' => 'Текущий',
    'Unknown' => 'Неизвестно',
    'and higher' => 'и выше',
    'Web server version' => 'Версия веб-сервера',
    'Version' => 'Версия',
    'PHP directives' => 'Директивы PHP',
    'default time zone' => 'часовой пояс, используемый по умолчанию',
    'Installer' => 'Установлен',
    'enable opcode caching' => 'разрешает кэширование опкодов',
    'includes support for URL wrappers' => 'включает поддержку обёрток URL (URL wrappers)',
    'support for working with URL a number of functions' => 'поддержка работы с URL ряду функций',
    'default encoding for functions' => 'кодировка по умолчанию для функций',
    'the maximum allowable size of data sent by the POST method' => 'максимально допустимый размер данных, отправляемых методом POST',
    'maximum uploaded size' => 'максимальный размер закачиваемого файла',
    'the maximum amount of memory a script is allowed to use' => 'максимальный объем памяти, который разрешается использовать скрипту',
    'maximum time in seconds for script loading' => 'максимальное время в секундах загрузки скрипта',
    'is short form PHP tags allowed' => 'разрешается ли короткая форма записи тегов PHP',
    'PHP Modules' => 'Модули PHP',
    'MySQL module' => 'Модуль MySQL',
    'working with MySQL database server' => 'работа с сервером базы данных MySQL',
    'Session module' => 'Модуль Сессии',
    'user session management' => 'управление сессиями пользователей',
    'JSON module' => 'Модуль JSON',
    'the module implements work with the JSON text data exchange format' => 'модуль реализует работу с текстовым форматом обмена данными JSON',
    'Module Multibyte strings' => 'Модуль Многобайтовые строки',
    'module provides functions for working with multibyte strings' => 'модуль предоставляет функции для работы с многобайтовыми строками',
    'cURL module' => 'Модуль cURL',
    'library of functions for working with URL' => 'библиотека функций работы с URL',
    'Internationalization module' => 'Модуль Интернационализации',
    'formatting, transliteration, encoding conversion, etc.' => 'форматирование, транслитерация, преобразование кодировок и т.д.',
    'Image processing module' => 'Модуль Обработки изображений',
    'working with image files in various formats' => 'работа с файлами изображений в различных форматах',
    'Zip compression and archiving module' => 'Модуль Сжатия и архивации Zip',
    'allows you to read and write to ZIP archives' => 'позволяет читать и записывать в ZIP-архивы',
    'libXML module' => 'Модуль libXML',
    'working with the XML file format' => 'работа с форматом файлов XML',
    'Redis server connection module' => 'Модуль подключения к серверу Redis',
    'storing data on a remote server' => 'хранение данных на удалённом сервере',
    // CommonChoice\StepCheck: сообщения
    'There are parameters that need to be corrected' => 'Есть параметры, которые необходимо будет исправить.',

    // CommonChoice\StepChoice: макет страницы
    'Installation selection' => 'Выбор установки',
    'Select installation type' => 'Выберите вид установки',
    'New installation' => 'Новая установка',
    'Install the GearMagic web application' => 'Установить веб-приложение GearMagic',
    'Attention! This choice may overwrite the previous installed version of the GearMagic Web application' 
        => 'Внимание! Этот выбор может переписать предыдущую установленную версию веб-приложение GearMagic',
    'Installed version update' => 'Обновление установленной версии',
    'Update files and database' => 'Обновление файлов и базы данных',
    'Update database connection settings' => 'Обновление параметров подключения к базе данных',
    'If in your web application, you only need to change the database connection settings' 
        => 'Если в вашем веб-приложении необходимо изменить только параметры подключения к базе данных',
    'Update the settings of installed components' => 'Обновление параметров установленных компонентов',
    'If the configuration files of installed components or their routing have been deleted or damaged, use this item' 
        => 'Если были удалены или повреждены файлы конфигурации установленных компонентов или их маршрутизация, то воспользуйтесь этим пунктом',
    // CommonChoice\StepChoice: сообщения
    'You need to select the installation type' => 'Вам необходимо выбрать вид установки.',

    // NewChoice\StepLicense: лицензионное соглашение
    'License' => 'Лицензия',
    'License agreement' => 'Лицензионное соглашение',
    'I have read and accept the license agreement' => 'Я прочитал и принимаю лицензионное соглашение',
    'Unable to load license agreement file "%s"' => 'Невозможно загрузить файл лицензионного соглашения "%s".',
    'To continue you must accept the license agreement' => 'Для продолжения Вам необходимо принять лицензионное соглашение.',

    // NewChoice\StepRegistration: макет страницы
    'Web application registration' => 'Регистрация веб-приложения',
    'Marketplace' => 'Маркетплейс',
    'A license key is required to receive updates and install new components via %s' 
        => 'Лицензионный ключ необходим для получения обновлений и установки новых компонентов через %s',
    'If the key is not specified, then there will be restrictions on the operation of your web application' 
        => 'Если ключ не будет указан, то будут ограничения в работе вашего веб-приложения',
    'The license key can be registered and specified after the web application is installed' 
        => 'Лицензионный ключ можно будет зарегистрировать и указать после установки веб-приложения',
    'License key' => 'Лицензионный ключ',
    'specify license key after installation' => 'указать лицензионный ключ после установки',
    // NewChoice\StepRegistration: поля
    'License Key' => 'Лицензионный ключ',

    // NewChoice\StepDb: макет страницы
    'Database connection' => 'Подключение к базе данных',
    'Enter information to connect to your web application\'s database' 
        => 'Введите информацию для соединения с базой данных вашего веб-приложения.',
    'If you don\'t already have a database, the installer will try to create one (unless the "%s" checkbox is selected)' 
        => 'Если у вас еще нет базы данных, то установщик попытается её создать (если не выбран флажок "%s")',
    'Table prefix' => 'Префикс таблиц',
    'Database user password' => 'Пароль пользователя базы данных',
    'Database username' => 'Имя пользователя базы данных',
    'Database name' => 'Имя базы данных',
    'Database server' => 'Сервер базы данных',
    'Server port' => 'Порт сервера',
    'Database' => 'База данных',
    'the database is already created on the server' => 'база данных уже создана на сервере',
    'Check connection' => 'Проверить подключение',
    'Database server connection check completed successfully' => '<b>Проверка подключения</b> к серверу базы данных выполнена успешно.',
    // NewChoice\StepDb: сообщения
    'Unable to find connection driver "%s"' => 'Невозможно найти драйвер подключения "%s"',

    // NewChoice\StepDbCharset: макет страницы
    'Charset selection' => 'Выбор кодировки',
    'Selecting the connection encoding' => 'Выбор кодировки подключения к северу базы данных',
    'Specify the encoding and collation for a correct connection to the database server' 
        => 'Укажите кодировку и сопоставление для корректного подключения к серверу базы данных',
    'use default UTF8 encoding' => 'использовать по умолчанию кодировку UTF8',
    'If you can\'t select the encoding and collation you want, then check "%s"' 
        => 'Если вы не можете выбрать нужную кодировку и сопоставление, тогда установите флажок "%s"',
    'The process may fail depending on the database settings or if the database user has insufficient privileges' 
        => 'Процесс может завершиться неудачей в зависимости от настроек базы данных или при недостаточных правах ее пользователя',
    '%s: the database will be created during the connection test "%s"' 
        => '<b>%s</b> при проверке подключения будет создана база данных <b>"%s"</b>',
    'If the database was previously created and you did not check the "%s" checkbox, then the connection check will fail' 
        => 'Если база данных ранее создана, а вы не установили флажок "%s", то при проверке подключения будет ошибка',
    'To fix the error, go back one step and check the box' 
        => 'Для исправления ошибки, вернитесь на шаг назад и установите флажок',
    'Charset' => 'Кодировка подключения',
    'Collate'  => 'Сопоставление',
    // NewChoice\StepDbCharset: сообщения
    'Attention! It is necessary in the previous step to select a database and make a connection' 
        => '<b>Внимание!</b> Необходимо в предыдущем шаге выбрать базу данных и сделать подключение.',
    'Database server connection check completed successfully' 
        => '<b>Проверка подключения</b> к серверу базы данных выполнено успешна.',
    'Database "%s" created successfully' => 'База данных <b>"%s"</b> успешно создана.',
    // NewChoice\StepDbCharset: ошибки
    'Error connecting to database server' => 'Ошибка подключения к серверу базы данных',
    'Database driver error' => 'Ошибка драйвера базы данных',
    'SQL query execution error' => 'Ошибка выполнения SQL-запроса',

    // NewChoice\StepCheckout: макет страницы
    'Checkout' => 'Контроль',
    'Web application files checkout' => 'Контроль доступа к файлам веб-приложения',
    'You can set the recommended access rights using the file manager or the control panel of your hosting' 
        => 'Установить рекомендуемые права доступа вы сможете с помощью файлового менеджера или панели управления вашего хостинга',
    'The files and directories of the web application must have the appropriate permissions' 
        => 'Файлы и каталоги веб-приложения должны иметь соответствующие права доступа',
    'If the files or directories do not have the recommended permissions, the installer will not be able to create or modify the configuration files' 
        => 'Если файлы или каталоги не имеют рекомендуемых прав доступа, то установщик не сможет создать или изменить файлы конфигурации, что приведёт к прерыванию установки',
    'Since you are using Windows OS, file and directory permissions will not be checked'
        => 'Так как вы используете <b>ОС Windows</b>, права доступа к файлам и каталогам не будут проверяться',
    // NewChoice\StepCheckout: таблица
    'Directory / file name' => 'Название каталога / файла',
    'Permissions' => 'Права доступа',
    'Exists' => 'Присутствует',
    // NewChoice\StepCheckout: сообщения
    'Need to set permissions "%s" to directory "%s".' => 'Необходимо установить права доступа "%s" каталогу "%s".',
    'Unable to determine directory permissions "%s".' => 'Невозможно определить права доступа к каталогу "%s".',
    'Directory "%s" does not exist.' => 'Каталог "%s" не существует.',
    'Need to set permissions "%s" to file "%s".' => 'Необходимо установить права доступа "%s" файлу "%s".',
    'Error writing to file. Unable to create or write file, no permissions.' => 'Ошибка записи в файл. Невозможно создать или записать файл, нет прав доступа.',
    'File template "%s" not found for installation.' => 'Шаблон файла "%s" для установки не найден.',
    'Unable to determine file permissions "%s".' => 'Невозможно определить права доступа к файлу "%s".',
    'File "%s" not found.' => 'Файл "%s" не найден.',
    // NewChoice\StepCheckout: файлы и каталоги
    'directory of web application files' => '<b>каталог</b> файлов веб-приложения',
    'directory of web application download files' => '<b>каталог</b> файлов загрузки веб-приложения',
    'directory for localizing web application files' => '<b>каталог</b> локализации файлов веб-приложения',
    'directory site files' => '<b>каталог</b> файлов сайта',
    'directory of web application temporary files' => '<b>каталог</b> временных файлов веб-приложения',
    'directory of web application component base templates' => '<b>каталог</b> базовых шаблонов компонентов веб-приложения',
    'directory of installed PHP libraries' => '<b>каталог</b> установленных библиотек PHP',
    'directory of web application components' => '<b>каталог</b> компонентов веб-приложения',
    'directory of web application configuration files' => '<b>каталог</b> файлов конфигурации веб-приложения',
    'installed widgets configuration file' => '<b>файл</b> конфигурации установленных виджетов',
    'installed modules configuration file' => '<b>файл</b> конфигурации установленных модулей',
    'configuration file of installed module extensions' => '<b>файл</b> конфигурации установленных расширений модулей',
    'shortcode manager configuration file (shortcodes)' => '<b>файл</b> конфигурации менеджера шорткодов (shortcodes)',
    'database connection configuration file' => '<b>файл</b> конфигурации подключений к базе данных',
    'web application configuration file' => '<b>файл</b> конфигурации веб-приложения',
    'license key file' => '<b>файл</b> лицензионного ключа',
    'web application unified configuration file' => '<b>файл</b> унифицированной конфигурации веб-приложения',
    'service manager configuration file' => '<b>файл</b> конфигурации менеджера служб',
    'language configuration file' => '<b>файл</b> конфигурации языков',
    'file system manager configuration file for Flysystem PHP package' => '<b>файл</b> конфигурации менеджера файловой системы для PHP-пакета Flysystem',
    'MIME type configuration file' => '<b>файл</b> конфигурации типов MIME',
    'control panel configuration file directory' => '<b>каталог</b> файлов конфигурации Панели управления',
    'control panel routing configuration file' => '<b>файл</b> конфигурации маршрутизации Панели управления',
    'control panel service manager configuration file' => '<b>файл</b> конфигурации менеджера служб Панели управления',
    'site configuration file directory' => '<b>каталог</b> файлов конфигурации сайта',
    'site routing configuration file' => '<b>файл</b> конфигурации маршрутизации сайта',
    'site service manager configuration file' => '<b>файл</b> конфигурации менеджера служб сайта',
    'console configuration files directory' => '<b>каталог</b> файлов конфигурации консоли',
    'console service manager configuration file' => '<b>файл</b> конфигурации менеджера служб консоли',

    // NewChoice\StepAssembly: макет страницы
    'Assembly' => 'Сборка',
    'Building a web application edition' => 'Сборка редакции веб-приложения',
    'Edition assembly is the search and installation of components (modules, module extensions, widgets) from the application repository' 
        => 'Сборка редакции - это поиск и установка компонентов (модулей, расширений модулей, виджетов) из репозитория веб-приложения',
    'Adding components to the database and updating configuration files' => 'Добавление компонентов в базу данных и обновление файлов конфигурации',
    'After searching for the components, click the "Install components" button' => 'После поиска компонентов, нажмите кнопку <b>"Установить компоненты"</b>',
    'Installed components will be highlighted with green checkmarks' => 'Установленные компоненты будут выделены зелеными галочками',
    'During the installation process, errors may occur due to the unstable operation of the web server' 
        => 'В процессе установки могут возникнуть ошибки связанные с нестабильной работой веб-сервера',
    'The following components were found in the repository' => 'В репозитории найдены следующие компоненты',
    'Application modules' => 'Модули веб-приложения',
    'Module name' => 'Название модуля',
    'Installed' => 'Установлен',
    'Application module extensions' => 'Расширения модулей веб-приложения',
    'Module extension name' => 'Название расширения модуля',
    'Application widgets' => 'Виджеты веб-приложения',
    'Widget name' => 'Название виджета',
    'Application plugins' => 'Плагины веб-приложения',
    'Plugin name' => 'Название плагина',
    'Install components' => 'Установить компоненты',
    'To populate your web application with data, you need to check the box below' 
        => 'Для наполнения данными вашего веб-приложения, вам необходимо установить флажок ниже',
    'Filling with demo data depends on the edition of your web application' 
        => 'Наполнение демонстрационными данные зависит от редакции вашего веб-приложения',
    'Apply demo data' => 'Применить демонстрационные данные',
    // NewChoice\StepAssembly: сообщения
    'Unable to install, missing modules in repository' => 'Невозможно выполнить установку, <b>отсутствуют модули</b> в репозитории',
    'BUILD Succeeded' => '<b>СБОРКА</b> редакции вашего веб-приложения выполнена успешно',
    // NewChoice\StepAssembly: ошибки
    'Unable to load SQL query map file "%s"' => 'Невозможно загрузить файл карты SQL-запросов "%s"',
    'No message, but call exception "%s"' =>  'Нет сообщения об ошибке, но был вызов исключения "<b>%s</b>".',
    'Perhaps your application has configuration files (*.so.php) - delete them' 
        => 'Возможно ваше приложение имеет уже созданные файлы конфигурации (*.so.php) - <b>удалите их</b>.',
    'SQL query map error' => 'Ошибка карты SQL-запросов',
    '%s SQL query: %s' => '%s <br><b>SQL-запрос:</b> %s',
    'Cannot write to database configuration file "%s"' => 'Невозможно выполнить запись в <b>файл конфигурации базы данных</b> "%s"',
    'Cannot write to configuration file "%s"' => 'Невозможно выполнить запись в <b>файл конфигурации</b> "%s"',
    'File write error' => 'Ошибка записи файла',
    'Errors occurred while installing modules' => 'В процессе установки модулей возникли ошибки.',
    'Errors occurred during the installation of module extensions' => 'В процессе установки расширений модулей возникли ошибки.',
    'Errors occurred while installing widgets' => 'В процессе установки виджетов возникли ошибки.',

    // NewChoice\StepDesign: макет страницы
    'Design' => 'Дизайн',
    'Web application design' => 'Дизайн веб-приложения',
    'Select a design template for your website and Control Panel' => 'Выберите шаблон дизайна для сайта и Панели управления',
    'The templates differ in their external design and basic settings' => 'Шаблоны отличаются внешним оформлением и базовыми настройками',
    'Website template' => 'Шаблон <b>Сайта</b>',
    'Panel Control template' => 'Шаблон <b>Панели управления</b>',
    'If you want to populate your web application with sample template data, you need to check the box below' =>
        'Если вы желаете наполнить ваше веб-приложение демонстрационными данными из шаблона, то вам необходимо установить флажок ниже',
    'Not all templates have demo data' => 'Не все шаблоны имеют демонстрационные данные',
    'Apply template demo data' => 'Применить демонстрационные данные шаблона',
    'there is demo data' => 'есть демонстрационные данные',
    // NewChoice\StepDesign: ошибки
    'You need to select the website theme' => 'Вам необходимо выбрать шаблон сайта.',
    'You need to select the Control Panel theme' => 'Вам необходимо выбрать шаблон Панели управления.',

    // NewChoice\StepInfo: макет страницы
    'Information' => 'Информация',
    'Web application information' => 'Информация о веб-приложение',
    'At this installation step, you must specify the name and description used in the templates and on the pages of your web application' 
        => 'На этом шаге установки необходимо указать название и описание, применяемые в шаблонах и на страницах вашего веб-приложения',
    'After installation, you can change or specify new values for each language' 
        => 'После установки, вы можете изменить или указать новые значения для каждого языка',
    'Name' => 'Название',
    'Description' => 'Описание',
    'The server\'s time zone will store data (taking into account the date and time) of users' 
        => 'В часовом поясе сервера будут храниться данные (с учётом даты и времени) пользователей',
    'Storing data in the same time zone will allow you to synchronize user interactions' 
        => 'Хранение данных в одном часовом поясе позволит синхронизировать  взаимодействие пользователей',
    'We recommend choosing: GMT (+00:00) UTC - Coordinated Universal Time' 
        => 'Рекомендуем выбрать: GMT (+00:00) UTC - всемирное координированное время',
    'Server timezone' => 'Часовой пояс сервера',
    'Default time zone, applies to users who do not have their own time zone specified' 
        => 'Часовой пояс по умолчанию, применяется для пользователей у которых не указан свой часовой пояс',
    'The date and time displayed in the application will correspond to this time zone' 
        => 'Дата и время выводимые в приложении будут соответствовать этому часовому поясу',
    'Default timezone' => 'Часовой пояс по умолчанию',

    // NewChoice\StepAccount: макет страницы
    'Create an account' => 'Создание аккаунта',
    'Create a user account' => 'Создание аккаунта пользователя',
    'At this stage, a Control panel user account is created with the "Super Administrator" user role' 
        => 'На этом этапе создаётся аккаунт пользователя Панели управления с ролью пользователя "Супер администратор"',
    'For a user with the "Super administrator" role, all installed components (modules, module extensions, widgets) are available with full access' 
        => 'Для пользователя с ролью "Супер администратор" доступны все установленные компоненты (модули, расширения модулей, виджеты) с полным доступом',
    'as well as the ability to add users and their roles' => 'а также возможность добавления пользователей и их ролей',
    'To access the Control Panel, you must specify the route (part of the URL path) without special characters (except for "-" and "_")' 
        => 'Для доступа к Панели управления необходимо указать маршрут (часть URL-пути) без специальных символов (исключение \'-\' и \'_\')',
    "For example: 'admin' etc." => "Например: 'admin', 'admin-ka' и т.д.",
    'Route to Control panel' => 'Маршрут к Панели управления',
    'Username' => 'Имя пользователя',
    'User password' => 'Пароль пользователя',
    'Password confirmation' => 'Подтверждение пароля',
    'Password and Confirm password do not match' => '<b>Пароль</b> и <b>Подтверждение пароля</b> не совпадают!',
    'Personal data' => 'Личные данные Администратора',
    'Call name' => 'Обращение',
    'First name' => 'Имя',
    'Second name' => 'Фамилия',
    'Patronymic name' => 'Отчество',
    'Admin' => 'Админушка',
    'Administrator' => 'Администратор',
    'how they will address you, for example: sir Ivan Ivanovich' => 'как будут к вам обращаться, например: сударь Иван Иванович',
    'To create account' => 'Создать аккаунт',
    'User account successfully created' => '<b>АККАУНТ</b> пользователя успешно создан',
    'Super administrator' => 'Супер администратор',
    'Super admins' => 'Супер администраторы',
    // NewChoice\StepAccount: ошибки
    'Cannot write to app configuration file "%s"' => 'Невозможно выполнить запись в <b>файл конфигурации веб-приложения</b> "%s"',

    // NewChoice\StepFinish
    'Finish' => 'Завершение',
    'Completing the installation' => 'Завершение установки',
    'Installation of edition "%s" of your web application completed successfully' => 'Установка редакции "%s" вашего веб-приложения успешно окончена',
    'For authorization in the Control panel, you will need to specify:' => 'Для авторизации в Панели управления, вам необходимо будет указать:',
    'After the installation is completed, it is recommended to delete the installer directory "%s" or follow the links: "%s", "%s"'
        => 'После завершения установки, рекомендуется удалить каталог установщика <b>"%s"</b> или перейти по ссылкам: "%s", "%s"',
    'After the installation is completed, it is recommended to delete the installer directory "%s" or follow the links "%s"'
        => 'После завершения установки, рекомендуется удалить каталог установщика <b>"%s"</b> или перейти по ссылке "%s"',
    'Start over' => 'Начать заново',
    'Go to Control panel' => 'Перейти в Панель управления',
    'Go to Website' => 'Перейти на Сайт',
    // NewChoice\StepFinish: ошибки
    'Unable to delete directory "%s" to stop the installer. Do it manually.' 
        => 'Невозможно выполнить удаление каталога <b>"%s"</b> для остановки установщика. Выполните это вручную.',

    // NewChoice\StepFinish
    'Database configuration file updated successfully' => 'Файл конфигурации базы данных успешно обнавлён',

    // Repair\StepAssembly: макет страницы
    'Updating' => 'Обновление',
    'Updating the settings will update (re-create) the following configuration files:' 
        => 'Обновление параметров позволит обновить (заново создать) следующие файлы конфигурации:',
    'configuration file of installed modules' => 'файл конфигурации установленных модулей',
    'configuration file of installed extensions' => 'файл конфигурации установленных расширений модулей',
    'configuration file of installed widgets' => 'файл конфигурации установленных виджетов',
    'shortcodes of installed components' => 'шорткоды установленных компонентов',
    'events of installed components' => 'события установленных компонентов',
    'routing components for the Site and Control Panel' => 'маршрутизация компонентов для Сайта и Панели управления',
    'After searching for components, click the "Update" button' => 'После поиска компонентов, нажмите кнопку "<b>Обновить</b>"',
    'Update' => 'Обновить',
    'Component configuration files updated successfully' => 'Файлы конфигурации компонентов обновлены успешно',
    // Repair\StepAssembly: ошибки
    'You need to install the web application' => 'Вам необходимо установить веб-приложение.',
];