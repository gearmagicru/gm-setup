<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Exception;
use Gm\Db\QueriesMap;
use Gm\Setup\SetupStep;
use Gm\Setup\Components;
use Gm\Db\Adapter\Adapter;
use Gm\Installer\AppConfigFile;
use Gm\Db\Exception\QueriesMapException;
use Gm\Db\Adapter\Exception\ConnectException;
use Gm\Db\Adapter\Exception\CommandException;
use Gm\Db\Adapter\Driver\Exception\DriverException;

/**
 * Шаг установки "Сборка редакции веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepAssembly extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'assembly';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/assembly';

    /**
     * Свернуть список расширений модулей.
     * 
     * @var bool
     */
    protected bool $collapseExtensions = true;

    /**
     * Свернуть список модулей.
     * 
     * @var bool
     */
    protected bool $collapseModules = true;

    /**
     * Свернуть список виджетов.
     * 
     * @var bool
     */
    protected bool $collapseWidgets = true;

    /**
     * Свернуть список плагинов.
     * 
     * @var bool
     */
    protected bool $collapsePlugins = true;

    /**
     * Компоненты веб-приложения.
     * 
     * @see StepAssembly::initParams()
     * 
     * @var Components
     */
    protected Components $components;

    /**
     * Карта SQL-запросов для устанавливаемой редакции веб-приложения.
     * 
     * @see StepAssembly::initParams()
     * 
     * @var QueriesMap
     */
    public QueriesMap $editionMap;

    /**
     * Адаптер подключения к базе данных.
     * 
     * @see StepAssembly::getAdapter()
     * 
     * @var Adapter|false
     */
    protected Adapter|false $adapter;

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:checkout');
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        parent::initParams();

        // согласиться с демоданными
        $this->state->applyDemo = ($_POST['applyDemo'] ?? false) === 'on';

        $this->editionMap = $this->installer->getQueriesMap([
            'autoload' => true,
            // параметры которые будут доступны в файле карты SQL-запросов
            'params' => [
                'applyDemo' => $this->state->applyDemo,
                'language'  => $this->state->language,
                'installer' => $this->installer
            ]
        ]);

        // если карта загружена
        if ($this->editionMap->loaded) {
            $this->components = new Components([
                'installer'    => $this->installer,
                'modulesId'    => array_flip($this->editionMap->getVar('modules')),
                'extensionsId' => array_flip($this->editionMap->getVar('extensions')),
                'widgetsId'    => array_flip($this->editionMap->getVar('widgets')),
                'pluginsId'    => array_flip($this->editionMap->getVar('plugins'))
            ]);

            if (!$this->hasAction()) {
                $this->state->modules    = $this->components->findModules();
                $this->state->extensions = $this->components->findExtensions();
                $this->state->widgets    = $this->components->findWidgets();
                $this->state->plugins    = $this->components->findPlugins();
                $this->updateState();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initAction(): void
    {
        parent::initAction();

        $this->params['modules'] = $this->state->modules ?? [];
        $this->params['widgets'] = $this->state->widgets ?? [];
        $this->params['extensions'] = $this->state->extensions ?? [];
        $this->params['plugins'] = $this->state->plugins ?? [];
        $this->params['collapseExtensions'] = $this->collapseExtensions;
        $this->params['collapseModules'] = $this->collapseModules;
        $this->params['collapseWidgets'] = $this->collapseWidgets;
        $this->params['collapsePlugins'] = $this->collapsePlugins;
    }

    /**
     * Возвращает адаптер подключения к базе данных.
     *
     * @return Adapter
     */
    protected function createAdapter(): Adapter
    {
        $params = [
            'host'     => $this->state->dbHost,
            'password' => $this->state->dbPassword,
            'username' => $this->state->dbUsername,
            'schema'   => $this->state->dbSchema,
            'port'     => $this->state->dbPort,
            'driver'   => $this->state->dbDriver,
            'charset'  => $this->state->dbCharset,
            'collate'  => $this->state->dbCollate,
            'engine'   => $this->state->dbEngine,
            'tablePrefix' => $this->state->dbTablePrefix
        ];

        $connections = new \Gm\Config\Config();
        $connections->setAll(['default' => $params]);

       return new Adapter([
            'connections'     => $connections,
            'connectionName'  => 'default',
            'enableProfiling' => false,
            'autoConnect'     => false
        ]);
    }

    /**
     * Создаёт подключение и возвращает адаптер подключения к базе данных.
     * 
     * @return Adapter|false
     * 
     * @throws ConnectException Ошибка подключения к серверу базы данных
     * @throws DriverException Ошибка драйвера базы данных
     * @throws CommandException Ошибка выполнения SQL-запроса
     */
    protected function getAdapter(): Adapter|false
    {
        if (!isset($this->adapter)) {
            try {
                $adapter = $this->createAdapter();
                $adapter->connect();
            } catch (ConnectException $exception) {
                $this->addError($exception->getMessage(), $this->t('Error connecting to database server'));
            } catch (DriverException $exception) {
                $this->addError($exception->getMessage(), $this->t('Database driver error'));
            } catch (CommandException $exception) {
                $this->addError($exception->getMessage(), $this->t('SQL query execution error'));
            }
            $this->adapter = isset($exception) ? false : $adapter;
        }
        return $this->adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Web application files checkout');
    }

    /**
     * Выполняет сборку модулей веб-приложения.
     * 
     * @return bool
     * 
     * @throws QueriesMapException Ошибка карты SQL-запросов
     * @throws CommandException Ошибка выполнения SQL-запроса
     */
    protected function assemblyModules(): bool
    {
        /** @var array $modules Все найденные модули */
        $modules = $this->state->modules ?? [];

        // сбрасываем статус сборки модулей
        foreach ($modules['items'] as $moduleId => &$module) {
            $module['assembled'] = false;
        }

        /** @var Adapter|false $adapter */
        $adapter = $this->getAdapter();
        if ($adapter === false) return false;

        /** @var QueriesMap $map Карта SQL-запросов модулей */
        $map = new QueriesMap([
            'adapter' => $adapter,
            'params'  => [
                'isSetup'   => true, // выполняет работу установщик приложения, а не менеджер
                'isRu'      => $this->installer->isRu(), // если языка установки русский (только для установщика приложения)
                'applyDemo' => $this->state->applyDemo, // применить демоданные (только для установщика приложения)
            ]
        ]);

        // для всех найденных модулей выполняем карту SQL-запросов
        foreach ($modules['items'] as $moduleId => &$module) {
            // если есть карта SQL-запросов
            if ($module['queries']) {
                $map->setFilename($module['queries']);
                $map->load();
                try {
                    $map->run('install');
                } catch (QueriesMapException $exception) {
                    $module['message'] = [
                        'message' => $exception->getMessage(),
                        'title'   => $this->t('SQL query map error'),
                        'type'    => 'error'
                    ];
                    break;
                } catch (CommandException $exception) {
                    $module['message'] = [
                        'message' => $this->t('%s SQL query: %s', [$exception->error, $map->getLastSql()]),
                        'title'   => $this->t('SQL query execution error'),
                        'type'    => 'error'
                    ];
                    break;
                }
            }
            $module['assembled'] = true;
        }

        // развернуть список модулей
        $this->collapseModules = false;
        // обновить состояние установки модулей
        $this->state->modules = $modules;
        return !isset($exception);
    }

    /**
     * Выполняет сборку расширений модулей веб-приложения.
     * 
     * @return bool
     * 
     * @throws QueriesMapException Ошибка карты SQL-запросов.
     * @throws CommandException Ошибка выполнения SQL-запроса.
     */
    protected function assemblyExtensions(): bool
    {
        /** @var array $extensions Все найденные расширения */
        $extensions = $this->state->extensions ?? [];

        // сбрасываем статус сборки расширений модулей
        foreach ($extensions['items'] as $extensionId => &$extension) {
            $extension['assembled'] = false;
        }

        /** @var Adapter|false $adapter */
        $adapter = $this->getAdapter();
        if ($adapter === false) return false;

        /** @var QueriesMap $map Карта SQL-запросов расширений модулей */
        $map = new QueriesMap([
            'adapter' => $adapter,
            'params'  => [
                'isSetup'   => true, // выполняет работу установщик приложения, а не менеджер
                'isRu'      => $this->installer->isRu(), // если языка установки русский (только для установщика приложения)
                'applyDemo' => $this->state->applyDemo, // применить демоданные (только для установщика приложения)
            ]
        ]);

        // для всех найденных модулей выполняем карту SQL-запросов
        foreach ($extensions['items'] as $extensionId => &$extension) {
            // если есть карта SQL-запросов
            if ($extension['queries']) {
                $map->setFilename($extension['queries']);
                $map->load();
                try {
                    $map->run('install');
                } catch (QueriesMapException $exception) {
                    $extension['message'] = [
                        'message' => $exception->getMessage(),
                        'title'   => $this->t('SQL query map error'),
                        'type'    => 'error'
                    ];
                    break;
                } catch (CommandException $exception) {
                    $extension['message'] = [
                        'message' => $this->t('%s SQL query: %s', [$exception->error, $map->getLastSql()]),
                        'title'   => $this->t('SQL query execution error'),
                        'type'    => 'error'
                    ];
                    break;
                }
            }
            $extension['assembled'] = true;
        }

        // развернуть список модулей
        $this->collapseExtensions = false;
        // обновить состояние установки расширений модулей
        $this->state->extensions = $extensions;
        return !isset($exception);
    }

    /**
     * Выполняет сборку виджетов веб-приложения.
     * 
     * @return bool
     */
    protected function assemblyWidgets(): bool
    {
        /** @var array $widgets Все найденные виджеты */
        $widgets = $this->state->widgets ?? [];

        foreach ($widgets['items'] as $widgetId => &$widget) {
            $widget['assembled'] = true;
        }

        // развернуть список виджетов
        $this->collapseWidgets = false;
        // обновить состояние установки виджетов
        $this->state->widgets = $widgets;
        return true;
    }

    /**
     * Выполняет сборку плагинов веб-приложения.
     * 
     * @return bool
     */
    protected function assemblyPlugins(): bool
    {
        /** @var array $plugins Все найденные плагины */
        $plugins = $this->state->plugins ?? [];

        foreach ($plugins['items'] as $pluginId => &$plugin) {
            $plugin['assembled'] = true;
        }

        // развернуть список плагинов
        $this->collapsePlugins = false;
        // обновить состояние установки плагинов
        $this->state->plugins = $plugins;
        return true;
    }

    /**
     * Выполняет сборку редакции веб-приложения.
     * 
     * @return bool
     * 
     * @throws QueriesMapException Ошибка карты SQL-запросов.
     * @throws CommandException Ошибка выполнения SQL-запроса.
     */
    protected function assemblyEdition(): bool
    {
        /** @var Adapter|false $adapter */
        $adapter = $this->getAdapter();
        if ($adapter === false) return false;

        try {
            $this->editionMap->adapter = $adapter;
            $this->editionMap->run('install');
        } catch (QueriesMapException $exception) {
            $this->addError(
                $exception->getMessage(),
                $this->t('SQL query map error')
            );
        } catch (CommandException $exception) {
            $this->addError(
                $this->t('%s SQL query: %s', [$exception->error, $this->editionMap->getLastSql()]),
                $this->t('SQL query execution error')
            );
        }

        if (isset($exception)) return false;

        try {
            /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
            $command = $adapter->createCommand();

            /** @var array $modules Все найденные модули */
            $modules = $this->state->modules['rows'] ?? [];
            foreach ($modules as $moduleId => $row) {
                $command
                    ->insert('{{module}}', $row)
                    ->execute();
            }

            /** @var array $extensions Все найденные расширения */
            $extensions = $this->state->extensions['rows'] ?? [];
            foreach ($extensions as $extensionId => $row) {
                $command
                    ->insert('{{extension}}', $row)
                    ->execute();
            }

            /** @var array $widgets Все найденные виджеты */
            $widgets = $this->state->widgets['rows'] ?? [];
            foreach ($widgets as $widgetId => $row) {
                $command
                    ->insert('{{widget}}', $row)
                    ->execute();
            }

            /** @var array $plugins Все найденные плагины */
            $plugins = $this->state->plugins['rows'] ?? [];
            foreach ($plugins as $pluginId => $row) {
                $command
                    ->insert('{{plugin}}', $row)
                    ->execute();
            }
        } catch (CommandException $exception) {
            $this->addError(
                $this->t('%s SQL query: %s', [$exception->error, $command->getSql()]),
                $this->t('SQL query execution error')
            );
        }

        if (isset($exception)) return false;

        try {
            /** @var \Gm\Mvc\Application $app */
            $app = $this->installer->getApp(true);

            /** @var \Gm\ModuleManager\ModuleRegistry $registry */
            $registry = $app->modules->getRegistry();
            $registry->update();

            /** @var \Gm\ExtensionManager\ExtensionRegistry $registry */
            $registry = $app->extensions->getRegistry();
            $registry->update();

            /** @var \Gm\WidgetManager\WidgetRegistry $registry */
            $registry = $app->widgets->getRegistry();
            $registry->update();

            /** @var \Gm\PluginManager\PluginRegistry $registry */
            $registry = $app->plugins->getRegistry();
            $registry->update();
        } catch (Exception $exception) {
            $message = $exception->getMessage();
            if (empty($message)) {
                $message = $this->t('No message, but call exception "%s"', [$exception::class]) . ' '
                         . $this->t('Perhaps your application has configuration files (*.so.php) - delete them');
            }
            $this->addError($message);
        }
        
        return !isset($exception);
    }

    /**
     * Создаёт файлы конфигурации веб-приложения.
     * 
     * @return bool
     */
    protected function createConfigFiles(): bool
    {
        /**
         * Файл конфигурации базы данных ".database.php".
         */
        $config = new AppConfigFile(CONFIG_PATH . DS . '.database.php');
        $created = $config->create([
            'driver'      => $this->state->dbDriver,
            'host'        => $this->state->dbHost,
            'password'    => $this->state->dbPassword,
            'username'    => $this->state->dbUsername,
            'schema'      => $this->state->dbSchema,
            'charset'     => $this->state->dbCharset,
            'collate'     => $this->state->dbCollate,
            'port'        => $this->state->dbPort,
            'tablePrefix' => $this->state->dbTablePrefix
        ]);
        if (!$created) {
            $this->addError(
                $this->t('Cannot write to database configuration file "%s"', [$config->getFilename()]),
                $this->t('File write error')
            );
            return false;
        }

        /**
         * Файл конфигурации лицензионного ключа ".license.php".
         */
        $licenseKeyAfter = $this->state->licenseKeyAfter ?? true;
        $config = new AppConfigFile(CONFIG_PATH . DS . '.license.php');
        $created = $config->create([
            'key' => $licenseKeyAfter ? $this->state->licenseKey : ''
        ]);
        if (!$created) {
            $this->addError(
                $this->t('Cannot write to configuration file "%s"', [$config->getFilename()]),
                $this->t('File write error')
            );
            return false;
        }
        return true;
    }

    /**
     * Выполняет действие "Assembly" (сборка редакции веб-приложения).
     * 
     * @return bool
     */
    protected function assemblyAction(): bool
    {
        // создание файлов конфигурации веб-приложения
        if (!$this->createConfigFiles()) {
            return false;
        }

        // сборка модулей
        if (!$this->assemblyModules()) {
            $this->addError($this->t('Errors occurred while installing modules'));
            $this->collapseExtensions = true;
            $this->collapseWidgets = true;
            return false;
        }

        // сборка расширений модулей
        if (!$this->assemblyExtensions()) {
            $this->addError($this->t('Errors occurred during the installation of module extensions'));
            $this->collapseWidgets = true;
            return false;
        }

        // сборка виджетов
        if (!$this->assemblyWidgets()) {
            $this->addError($this->t('Errors occurred while installing widgets'));
            return false;
        }

        // сборка плагинов
        if (!$this->assemblyPlugins()) {
            $this->addError($this->t('Errors occurred while installing plugins'));
            return false;
        }

        // сборка редакции
        if (!$this->assemblyEdition()) {
            return false;
        }

        // отметить завершение шага
        $this->complete();
        // обновить изменения сделанные шагом
        $this->updateState();
        return true;
    }
}