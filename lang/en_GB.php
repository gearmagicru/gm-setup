<?php
/**
 * Этот файл является частью модуля веб-приложения GearMagic.
 * 
 * Пакет английской (британской) локализации.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

return [
    '{name}'        => 'Installer',
    '{description}' => 'Installing a web application eddition',
    '{permissions}' => [],

    // Setup
    'Setup' => 'Setup',
    'edition' => 'edition',
    'You need to fill Attention the field "%s"' => 'You need to fill in the field "%s".',
    'Attention!' => 'Attention!',
    'required fields' => 'required fields',
    'Error' => 'Error',
    'Warning' => 'Warning',
    'characters must be more than %s but less than %s' => 'Characters must be more than %s but less than %s',
    'characters must be more than %s' => 'Characters must be more than %s',
    'characters must not exceed %s' => 'Characters must not exceed %s', 
    'The field "%s" must have no more than %s but less than %s characters' => 'The field "<b>%s</b>" must have no more than <b>%s</b> but less than <b>%s</b> characters.',
    'The field "%s" must have at least %s characters' => 'The field "<b>%s</b>" must have at least <b>%s</b> characters.',
    'The field "%s" must have no more than %s characters' => 'The field "<b>%s</b>" must have no more than <b>%s</b> characters.',
    
    // Setup: макет страницы
    'Welcome' => 'Welcome',
    'Registration' => 'Registration',
    'Check' => 'Check',
    'Setup selection' => 'Setup selection',
    'Database selection' => 'Database selection',
    'Back' => 'Back',
    'Next' => 'Next',
    'Check connection' => 'Check connection',

    // 404: макет страницы
    'Web application installer' => 'Web application installer',
    'install' => 'install',
    'To install the web application follow the link %s' => 'To install the web application follow the link %s',
    'If you don\'t need an installer or the web application is already installed then remove the directory "%s"' 
        => 'If you don\'t need an installer or the web application is already installed then remove the directory "%s"',

    // CommonChoice\StepWelcome: макет страницы
    'Welcome to the GearMagic installation' => 'Welcome to the GearMagic installation',
    'You will be guided through the entire installation process' => 'You will be guided through the entire installation process',
    'Please click the «Next» button to continue' => 'Please click the «Next» button to continue',
    'Choose language' => 'Choose language',
    // CommonChoice\StepWelcome: сообщения
    'You need to select a language' => 'You need to select a language',

    // CommonChoice\StepCheck: макет страницы
    'Preliminary check' => 'Preliminary check',
    'Your web application must meet the required parameters' 
        => 'Your web application must meet the required parameters',
    'If one of the parameters is highlighted in red, then you need to fix it' 
        => 'If one of the parameters is highlighted in red, then you need to fix it',
    'If you continue with the installation without patching, your web application may be broken' 
        => 'If you continue with the installation without patching, your web application may be broken',
    'Installed' => 'Installed',
    'Not installed' => 'Not installed',
    'Not loaded' => 'Not loaded',
    'Loaded' => 'Loaded',
    'Parameter' => 'Parameter',
    'Required' => 'Required',
    'Current' => 'Current',
    'Unknown' => 'Unknown',
    'and higher' => 'and higher',
    'Web server version' => 'Web server version',
    'Version' => 'Version',
    'PHP directives' => 'PHP directives',
    'default time zone' => 'default time zone',
    'Installer' => 'Installer',
    'enable opcode caching' => 'enable opcode caching',
    'includes support for URL wrappers' => 'includes support for URL wrappers',
    'support for working with URL a number of functions' => 'support for working with URL a number of functions',
    'default encoding for functions' => 'default encoding for functions',
    'the maximum allowable size of data sent by the POST method' => 'the maximum allowable size of data sent by the POST method',
    'maximum uploaded size' => 'maximum uploaded size',
    'the maximum amount of memory a script is allowed to use' => 'the maximum amount of memory a script is allowed to use',
    'maximum time in seconds for script loading' => 'maximum time in seconds for script loading',
    'is short form PHP tags allowed' => 'is short form PHP tags allowed',
    'PHP Modules' => 'PHP Modules',
    'MySQL module' => 'MySQL module',
    'working with MySQL database server' => 'working with MySQL database server',
    'Session module' => 'Session module',
    'user session management' => 'user session management',
    'JSON module' => 'JSON module',
    'the module implements work with the JSON text data exchange format' => 'the module implements work with the JSON text data exchange format',
    'Module Multibyte strings' => 'Module Multibyte strings',
    'module provides functions for working with multibyte strings' => 'module provides functions for working with multibyte strings',
    'cURL module' => 'cURL module',
    'library of functions for working with URL' => 'library of functions for working with URL',
    'Internationalization module' => 'Internationalization module',
    'formatting, transliteration, encoding conversion, etc.' => 'formatting, transliteration, encoding conversion, etc.',
    'Image processing module' => 'Image processing module',
    'working with image files in various formats' => 'working with image files in various formats',
    'Zip compression and archiving module' => 'Zip compression and archiving module',
    'allows you to read and write to ZIP archives' => 'allows you to read and write to ZIP archives',
    'libXML module' => 'libXML module',
    'working with the XML file format' => 'working with the XML file format',
    'Redis server connection module' => 'Redis server connection module',
    'storing data on a remote server' => 'storing data on a remote server',
    // CommonChoice\StepCheck: сообщения
    'There are parameters that need to be corrected' => 'There are parameters that need to be corrected.',

    // CommonChoice\StepChoice: макет страницы
    'Installation selection' => 'Installation selection',
    'Select installation type' => 'Select installation type',
    'New installation' => 'New installation',
    'Install the GearMagic web application' => 'Install the GearMagic web application',
    'Attention! This choice may overwrite the previous installed version of the GearMagic Web application' 
        => 'Attention! This choice may overwrite the previous installed version of the GearMagic Web application',
    'Installed version update' => 'Installed version update',
    'Update files and database' => 'Update files and database',
    'Update database connection settings' => 'Update database connection settings',
    'If in your web application, you only need to change the database connection settings' 
        => 'If in your web application, you only need to change the database connection settings',
    'Update the settings of installed components' => 'Update the settings of installed components',
    'If the configuration files of installed components or their routing have been deleted or damaged, use this item' 
        => 'If the configuration files of installed components or their routing have been deleted or damaged, use this item',    
    // CommonChoice\StepChoice: сообщения
    'You need to select the installation type' => 'You need to select the installation type.',

    // NewChoice\StepLicense: лицензионное соглашение
    'License' => 'License',
    'License agreement' => 'License agreement',
    'I have read and accept the license agreement' => 'I have read and accept the license agreement',
    'To continue you must accept the license agreement' => 'To continue you must accept the license agreement.',

    // NewChoice\StepRegistration: макет страницы
    'Web application registration' => 'Web application registration',
    'Marketplace' => 'Marketplace',
    'A license key is required to receive updates and install new components via %s' 
        => 'A license key is required to receive updates and install new components via %s',
    'If the key is not specified, then there will be restrictions on the operation of your web application' 
        => 'If the key is not specified, then there will be restrictions on the operation of your web application',
    'The license key can be registered and specified after the web application is installed' 
        => 'The license key can be registered and specified after the web application is installed',
    'License key' => 'License key',
    'specify license key after installation' => 'specify license key after installation',
    // NewChoice\StepRegistration: поля
    'License Key' => 'License Key',

    // NewChoice\StepDb: макет страницы
    'Database connection' => 'Database connection',
    'Enter information to connect to your web application\'s database' 
        => 'Enter information to connect to your web application\'s database.',
    'If you don\'t already have a database, the installer will try to create one (unless the "%s" checkbox is selected)' 
        => 'If you don\'t already have a database, the installer will try to create one (unless the "%s" checkbox is selected)',
    'Table prefix' => 'Table prefix',
    'Database user password' => 'Database user password',
    'Database username' => 'Database username',
    'Database name' => 'Database name',
    'Database server' => 'Database server',
    'Server port' => 'Server port',
    'Database' => 'Database',
    'the database is already created on the server' => 'the database is already created on the server',
    'Check connection' => 'Check connection',
    'Database server connection check completed successfully' => '<b>Database server connection</b> check completed successfully.',
    // NewChoice\StepDb: сообщения
    'Unable to find connection driver "%s"' => 'Unable to find connection drive "%s"',

    // NewChoice\StepDbCharset: макет страницы
    'Charset selection' => 'Charset selection',
    'Selecting the connection encoding' => 'Selecting the connection encoding',
    'Specify the encoding and collation for a correct connection to the database server' 
        => 'Specify the encoding and collation for a correct connection to the database server',
    'use default UTF8 encoding' => 'use default UTF8 encoding',
    'If you can\'t select the encoding and collation you want, then check "%s"' 
        => 'If you can\'t select the encoding and collation you want, then check "%s"',
    'The process may fail depending on the database settings or if the database user has insufficient privileges' 
        => 'The process may fail depending on the database settings or if the database user has insufficient privileges',
    '%s: the database will be created during the connection test "%s"' 
        => '<b>%s</b>: the database will be created during the connection test <b>"%s"</b>',
    'If the database was previously created and you did not check the "%s" checkbox, then the connection check will fail' 
        => 'If the database was previously created and you did not check the "%s" checkbox, then the connection check will fail',
    'To fix the error, go back one step and check the box' 
        => 'To fix the error, go back one step and check the box',
    'Charset' => 'Charset',
    'Collate'  => 'Collate',
    // NewChoice\StepDbCharset: сообщения
    'Attention! It is necessary in the previous step to select a database and make a connection' 
        => '<b>Attention!</b> It is necessary in the previous step to select a database and make a connection.',
    'Database server connection check completed successfully' 
        => '<b>Database server connection</b> check completed successfully.',
    'Database "%s" created successfully' => 'Database <b>"%s"</b> created successfully.',
    // NewChoice\StepDbCharset: ошибки
    'Error connecting to database server' => 'Error connecting to database server',
    'Database driver error' => 'Database driver error',
    'SQL query execution error' => 'SQL query execution error',

    // NewChoice\StepCheckout: макет страницы
    'Checkout' => 'Checkout',
    'Web application files checkout' => 'Web application files checkout',
    'You can set the recommended access rights using the file manager or the control panel of your hosting' 
        => 'You can set the recommended access rights using the file manager or the control panel of your hosting',
    'The files and directories of the web application must have the appropriate permissions' 
        => 'The files and directories of the web application must have the appropriate permissions',
    'If the files or directories do not have the recommended permissions, the installer will not be able to create or modify the configuration files' 
        => 'If the files or directories do not have the recommended permissions, the installer will not be able to create or modify the configuration files',
    'Since you are using Windows OS, file and directory permissions will not be checked'
        => 'Since you are using <b>Windows OS</b>, file and directory permissions will not be checked',
    // NewChoice\StepCheckout: таблица
    'Directory / file name' => 'Directory / file name',
    'Permissions' => 'Permissions',
    'Exists' => 'Exists',
    // NewChoice\StepCheckout: сообщения
    'Need to set permissions "%s" to directory "%s".' => 'Need to set permissions "%s" to directory "%s".',
    'Unable to determine directory permissions "%s".' => 'Unable to determine directory permissions "%s".',
    'Directory "%s" does not exist.' => 'Directory "%s" does not exist.',
    'Need to set permissions "%s" to file "%s".' => 'Need to set permissions "%s" to file "%s".',
    'Error writing to file. Unable to create or write file, no permissions.' => 'Error writing to file. Unable to create or write file, no permissions.',
    'File template "%s" not found for installation.' => 'File template "%s" not found for installation.',
    'Unable to determine file permissions "%s".' => 'Unable to determine file permissions "%s".',
    'File "%s" not found.' => 'File "%s" not found.',
    // NewChoice\StepCheckout: файлы и каталоги
    'directory of web application files' => '<b>directory</b> of web application files',
    'directory of web application download files' => '<b>directory</b> of web application download files',
    'directory for localizing web application files' => '<b>directory</b> for localizing web application files',
    'directory site files' => '<b>directory</b> site files',
    'directory of web application temporary files' => '<b>directory</b> of web application temporary files',
    'directory of web application component base templates' => '<b>directory</b> of web application component base templates',
    'directory of installed PHP libraries' => '<b>directory</b> of installed PHP libraries',
    'directory of web application components' => '<b>directory</b> of web application components',
    'directory of web application configuration files' => '<b>directory</b> of web application configuration files',
    'installed widgets configuration file' => 'installed widgets configuration <b>file</b>',
    'installed modules configuration file' => 'installed modules configuration <b>file</b>',
    'configuration file of installed module extensions' => 'configuration <b>file</b> of installed module extensions',
    'shortcode manager configuration file (shortcodes)' => 'shortcode manager configuration <b>file</b> (shortcodes)',
    'database connection configuration file' => 'database connection configuration <b>file</b>',
    'web application configuration file' => 'web application configuration <b>file</b>',
    'license key file' => 'license key <b>file</b>',
    'web application unified configuration file' => 'web application unified configuration <b>file</b>',
    'service manager configuration file' => 'service manager configuration <b>file</b>',
    'language configuration file' => 'language configuration <b>file</b>',
    'file system manager configuration file for Flysystem PHP package' => '<b>file</b> system manager configuration file for Flysystem PHP package',
    'MIME type configuration file' => 'MIME type configuration <b>file</b>',
    'control panel configuration file directory' => 'control panel configuration file <b>directory</b>',
    'control panel routing configuration file' => 'control panel routing configuration <b>file</b>',
    'control panel service manager configuration file' => 'control panel service manager configuration <b>file</b>',
    'site configuration file directory' => 'site configuration file <b>directory</b>',
    'site routing configuration file' => 'site routing configuration <b>file</b>',
    'site service manager configuration file' => 'site service manager configuration <b>file</b>',
    'console configuration files directory' => 'console configuration files <b>directory</b>',
    'console service manager configuration file' => 'console service manager configuration <b>file</b>',

    // NewChoice\StepAssembly: макет страницы
    'Building a web application edition' => 'Building a web application edition',
    'Edition assembly is the search and installation of components (modules, module extensions, widgets) from the application repository' 
        => 'Edition assembly is the search and installation of components (modules, module extensions, widgets) from the application repository',
    'Adding components to the database and updating configuration files' => 'Adding components to the database and updating configuration files',
    'After searching for the components, click the "Install components" button' => 'After searching for the components, click the <b>"Install components"</b> button',
    'Installed components will be highlighted with green checkmarks' => 'Installed components will be highlighted with green checkmarks',
    'During the installation process, errors may occur due to the unstable operation of the web server' 
        => 'During the installation process, errors may occur due to the unstable operation of the web server',
    'The following components were found in the repository' => 'The following components were found in the repository',
    'Application modules' => 'Application modules',
    'Module name' => 'Module name',
    'Installed' => 'Installed',
    'Application module extensions' => 'Application module extensions',
    'Module extension name' => 'Module extension name',
    'Application widgets' => 'Application widgets',
    'Widget name' => 'Widget name',
    'Application plugins' => 'Application plugins',
    'Plugin name' => 'Plugin name',
    'Install components' => 'Install components',
    'To populate your web application with data, you need to check the box below' 
        => 'To populate your web application with data, you need to check the box below',
    'Filling with demo data depends on the edition of your web application' 
        => 'Filling with demo data depends on the edition of your web application',
    'Apply demo data' => 'Apply demo data',
    // NewChoice\StepAssembly: сообщения
    'Unable to install, missing modules in repository' => 'Unable to install, <b>missing modules</b> in repository',
    'BUILD Succeeded' => '<b>BUILD</b> Succeeded',
    // NewChoice\StepAssembly: ошибки
    'Unable to load SQL query map file "%s"' => 'Unable to load SQL query map file "%s"',
    'No message, but call exception "%s"' =>  'No message, but call exception "<b>%s</b>".',
    'Perhaps your application has configuration files (*.so.php) - delete them' 
        => 'Perhaps your application has configuration files (*.so.php) - <b>delete them</b>.',
    'SQL query map error' => 'SQL query map error',
    '%s SQL query: %s' => '%s <br><b>SQL query:</b> %s',
    'Cannot write to database configuration file "%s"' => 'Cannot write to <b>database configuration file<b> "%s"',
    'Cannot write to configuration file "%s"' => 'Cannot write to <b>configuration file</b> "%s"',
    'File write error' => 'File write error',
    'Errors occurred while installing modules' => 'Errors occurred while installing modules.',
    'Errors occurred during the installation of module extensions' => 'Errors occurred during the installation of module extensions.',
    'Errors occurred while installing widgets' => 'Errors occurred while installing widgets.',

    // NewChoice\StepDesign: макет страницы
    'Design' => 'Design',
    'Web application design' => 'Web application design',
    'Select a design template for your website and Control Panel' => 'Select a design template for your website and Control Panel',
    'The templates differ in their external design and basic settings' => 'The templates differ in their external design and basic settings',
    'Website template' => 'Template <b>Website</b>',
    'Panel Control template' => 'Template <b>Panel Control</b>',
    'If you want to populate your web application with sample template data, you need to check the box below' =>
        'If you want to populate your web application with sample template data, you need to check the box below',
    'Not all templates have demo data' => 'Not all templates have demo data',
    'Apply template demo data' => 'Apply template demo data',
    'there is demo data' => 'there is demo data',
    // NewChoice\StepDesign: ошибки
    'You need to select the website theme' => 'You need to select the website theme.',
    'You need to select the Control Panel theme' => 'You need to select the Control Panel theme.',

    // NewChoice\StepInfo: макет страницы
    'Information' => 'Information',
    'Web application information' => 'Web application information',
    'At this installation step, you must specify the name and description used in the templates and on the pages of your web application' 
        => 'At this installation step, you must specify the name and description used in the templates and on the pages of your web application',
    'After installation, you can change or specify new values for each language' 
        => 'After installation, you can change or specify new values for each language',
    'Name' => 'Name',
    'Description' => 'Description',
    'The server\'s time zone will store data (taking into account the date and time) of users' 
        => 'The server\'s time zone will store data (taking into account the date and time) of users',
    'Storing data in the same time zone will allow you to synchronize user interactions' 
        => 'Storing data in the same time zone will allow you to synchronize user interactions',
    'We recommend choosing: GMT (+00:00) UTC - Coordinated Universal Time' 
        => 'We recommend choosing: GMT (+00:00) UTC - Coordinated Universal Time',
    'Server timezone' => 'Server timezone',
    'Default time zone, applies to users who do not have their own time zone specified' 
        => 'Default time zone, applies to users who do not have their own time zone specified',
    'The date and time displayed in the application will correspond to this time zone' 
        => 'The date and time displayed in the application will correspond to this time zone',
    'Default timezone' => 'Default timezone',

    // NewChoice\StepAccount: макет страницы
    'Create a user account' => 'Create a user account',
    'At this stage, a Control panel user account is created with the "Super Administrator" user role' 
        => 'At this stage, a Control panel user account is created with the "Super Administrator" user role',
    'For a user with the "Super administrator" role, all installed components (modules, module extensions, widgets) are available with full access' 
        => 'For a user with the "Super administrator" role, all installed components (modules, module extensions, widgets) are available with full access',
    'as well as the ability to add users and their roles' => 'as well as the ability to add users and their roles',
    'To access the Control Panel, you must specify the route (part of the URL path) without special characters (except for "-" and "_")' 
        => 'To access the Control Panel, you must specify the route (part of the URL path) without special characters (except for "-" and "_")',
    "For example: 'admin' etc." => "For example: 'admin' etc.",
    'Route to Control panel' => 'Route to Control panel',
    'Username' => 'Username',
    'User password' => 'User password',
    'Password confirmation' => 'Password confirmation',
    'Password and Confirm password do not match' => '<b>Password</b> and <b>Confirm password</b> do not match!',
    'Personal data' => 'Personal data',
    'Call name' => 'Call name',
    'First name' => 'First name',
    'Second name' => 'Second name',
    'Patronymic name' => 'Patronymic name',
    'Admin' => 'Admin',
    'Administrator' => 'Administrator',
    'how they will address you, for example: sir Ivan Ivanovich' => 'how they will address you, for example: sir Ivan Ivanovich',
    'To create account' => 'To create account',
    'User account successfully created' => '<b>User accoun</b> successfully created',
    'Super administrator' => 'Super administrator',
    'Super admins' => 'Super admins',
    // NewChoice\StepAccount: ошибки
    'Cannot write to app configuration file "%s"' => 'Cannot write to <b>app configuration file</b> "%s"',

    // NewChoice\StepFinish
    'Completing the installation' => 'Completing the installation',
    'Installation of edition "%s" of your web application completed successfully' => 'Installation of edition "%s" of your web application completed successfully',
    'For authorization in the Control panel, you will need to specify:' => 'For authorization in the Control panel, you will need to specify:',
    'After the installation is completed, it is recommended to delete the installer directory "%s" or follow the links: "%s", "%s"'
        => 'After the installation is completed, it is recommended to delete the installer directory <b>"%s"</b> or follow the links: "%s", "%s"',
    'After the installation is completed, it is recommended to delete the installer directory "%s" or follow the links "%s"'
        => 'After the installation is completed, it is recommended to delete the installer directory "%s" or follow the links "%s"',
    'Start over' => 'Start over',
    'Go to Control panel' => 'Go to Control panel',
    'Go to Website' => 'Go to Website',
    // NewChoice\StepFinish: ошибки
    'Unable to delete directory "%s" to stop the installer. Do it manually.' 
        => 'Unable to delete directory <b>"%s"</b> to stop the installer. Do it manually.',

    // NewChoice\StepFinish
    'Database configuration file updated successfully' => 'Database configuration file updated successfully',

    // Repair\StepAssembly: макет страницы
    'Updating' => 'Updating',
    'Updating the settings will update (re-create) the following configuration files:' 
        => 'Updating the settings will update (re-create) the following configuration files:',
    'configuration file of installed modules' => 'configuration file of installed modules',
    'configuration file of installed extensions' => 'configuration file of installed extensions',
    'configuration file of installed widgets' => 'configuration file of installed widgets',
    'shortcodes of installed components' => 'shortcodes of installed components',
    'events of installed components' => 'events of installed components',
    'routing components for the Site and Control Panel' => 'routing components for the Site and Control Panel',
    'After searching for components, click the "Update" button' => 'After searching for components, click the "<b>Update</b>" button',
    'Update' => 'Update',
    'Component configuration files updated successfully' => 'Component configuration files updated successfully',
    // Repair\StepAssembly: ошибки
    'You need to install the web application' => 'You need to install the web application.',
];
