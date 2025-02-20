<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup;

use Gm\Stdlib\BaseObject; 
use Gm\Installer\Installer;

/**
 * Класс предназначен для поиска компонентов устанавливаемой редакции веб-приложения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup
 * @since 1.0
 */
class Components extends BaseObject
{
    /**
     * @var string Вид компонента - Модуль.
     */
    public const CMP_MODULE = 'Module';

    /**
     * @var string Вид компонента - Расширение модуля.
     */
    public const CMP_EXTENSION = 'Extension';

    /**
     * @var string Вид компонента - Виджет.
     */
    public const CMP_WIDGET = 'Widget';

    /**
     * @var string Вид компонента - Плагин.
     */
    public const CMP_PLUGIN = 'Plugin';

    /**
     * Установщик.
     * 
     * @var Installer
     */
    public Installer $installer;

    /**
     * URL-адрес отсутствующего значка компонента.
     * 
     * @var string
     */
    public string $iconNone = '';

    /**
     * Найденные модули устанавливаемого веб-приложения.
     * 
     * @see Components::findModules()
     * 
     * @var array
     */
    public array $modules;

    /**
     * Идентификаторы модулей, конфигурацию которых необходимо найти.
     * 
     * @var null|array
     */
    public array $modulesId;

    /**
     * Идентификаторы расширений модулей, конфигурацию которых необходимо найти.
     * 
     * @var null|array
     */
    public array $extensionsId;

    /**
     * Идентификаторы виджетов, конфигурацию которых необходимо найти.
     * 
     * @var null|array
     */
    public array $widgetsId;

    /**
     * Идентификаторы плагинов, конфигурацию которых необходимо найти.
     * 
     * @var null|array
     */
    public array $pluginsId;

    /**
     * Найденные виджеты устанавливаемого веб-приложения.
     * 
     * @see Components::findWidgets()
     * 
     * @var array
     */
    public array $widgets;

    /**
     * Найденные плагины устанавливаемого веб-приложения.
     * 
     * @see Components::findPlugins()
     * 
     * @var array
     */
    public array $plugins;

    /**
     * Найденные расширения модулей устанавливаемого веб-приложения.
     * 
     * @see Components::findExtensions()
     * 
     * @var array
     */
    public array $extensions;

    /**
     * Идентификаторы: виджетов, модулей и их расширений, которые являются системными.
     * 
     * @see Components::getLocked()
     * 
     * @var array
     */
    public array $locked;

    /**
     * Возвращает идентификаторы системных виджетов, модулей и их расширений.
     * 
     * Такие компоненты не устанавливаются, они интегрированы в приложение.
     * 
     * @return array
     */
    protected function getLocked(): array
    {
        if (!isset($this->locked)) {
            $modules = $this->installer->getAppConfig('.modules.php');
            if ($modules) {
                $modules = array_fill_keys(array_keys($modules), true);
            }

            $extensions = $this->installer->getAppConfig('.extensions.php');
            if ($extensions) {
                $extensions = array_fill_keys(array_keys($extensions), true);
            }

            $widgets = $this->installer->getAppConfig('.widgets.php');
            if ($widgets) {
                $widgets = array_fill_keys(array_keys($widgets), true);
            }

            $plugins = $this->installer->getAppConfig('.plugins.php');
            if ($plugins) {
                $plugins = array_fill_keys(array_keys($plugins), true);
            }
            $this->locked = [
                'modules'    => $modules,
                'extensions' => $extensions,
                'widgets'    => $widgets,
                'plugins'    => $plugins
            ]; 
        }
        return $this->locked;
    }

    /**
     * Возвращает конфигурацию модулей.
     * 
     * Идентификаторы модулей указаны в {@see Components::$modulesId}.
     * 
     * @see Components::find()
     * 
     * @return array
     */
    public function findModules(): array
    {
        if (!isset($this->modules)) {
            $this->modules = $this->find(self::CMP_MODULE, $this->modulesId);
        }
        return $this->modules;
    }

    /**
     * Возвращает конфигурацию виджетов.
     * 
     * Идентификаторы виджетов указаны в {@see Components::$widgetsId}.
     * 
     * @see Components::find()
     * 
     * @return array
     */
    public function findWidgets(): array
    {
        if (!isset($this->widgets)) {
            $this->widgets = $this->find(self::CMP_WIDGET, $this->widgetsId);
        }
        return $this->widgets;
    }

    /**
     * Возвращает конфигурацию плагинов.
     * 
     * Идентификаторы плагинов указаны в {@see Components::$pluginsId}.
     * 
     * @see Components::find()
     * 
     * @return array
     */
    public function findPlugins(): array
    {
        if (!isset($this->plugins)) {
            $this->plugins = $this->find(self::CMP_PLUGIN, $this->pluginsId);
        }
        return $this->plugins;
    }

    /**
     * Возвращает конфигурацию расширений модулей.
     * 
     * Идентификаторы расширений модулей указаны в {@see Components::$extensionsId}.
     * 
     * @see Components::find()
     * 
     * @return array
     */
    public function findExtensions(): array
    {
        if (!isset($this->extensions)) {
            $this->extensions = $this->find(self::CMP_EXTENSION, $this->extensionsId);
        }
        return $this->extensions;
    }

    /**
     * Возвращает конфигурацию указанных компонентов приложения.
     * 
     * @param string $component Вид компонентов (`Components::CMP_MODULE`, 'Components::CMP_WIDGET', 
     *     'Components::CMP_EXTENSION`), конфигурацию которых необходимо получить.
     * @param array $componentsId Идентификаторы компонентов, конфигурацию которых 
     *     необходимо получить.
     * 
     * @return array
     */
    public function find(string $component, ?array $componentsId): array
    {
        if (empty($componentsId)) {
            return ['rows' => [], 'items' => [], 'permissions' => []];
        }

        $this->locked = $this->getLocked();

        $iconNone = $this->installer->getAssetsUrl() . '/img/icon-component.svg';
        $locale   = $this->installer->getLocale();
        $basePath = BASE_PATH . MODULE_PATH . DS;

        /** @var array $searchFolders Папки компонентов */
        $searchFolders = $this->installer->getSearchFolders();

        /** @var int $uniqid 
         * Уникальный идентификатор записи в базе данных для каждого 
         * компонента, он должен совпадать с порядковым номером массива $componentId.
         * Если компонент не найден, то идентификатор записи пропускается!!!
         */
        $uniqid = 0;
        // поиск файлов конфигурации установки $filename
        $rows = $items = $perms = [];
        foreach ($componentsId as $rowId => $componentId) {
            $uniqid++;
            $pathExists = false;
            foreach ($searchFolders as $folder) {
                $path = $basePath . $folder . DS . $componentId;
                if (file_exists($path)) {
                    $pathExists = true;
                    break;
                }
            }
            // если папка компонента не существует
            if (!$pathExists) continue;

            /** @var string $baseUrl URL-путь к компоненту */
            $baseUrl = BASE_URL . MODULE_BASE_URL . '/' . $folder;

            // файл конфигурации установки компонента
            $installFile = $path . DS . 'config' . DS . '.install.php';
            if (!file_exists($installFile)) continue;

            // файл версии компонента
            $versionFile = $path . DS . 'config' . DS . '.version.php';
            if (!file_exists($versionFile)) continue;

            /** @var array $install Параметры конфигурации установки */
            $install = require($installFile);
            if (empty($install)) continue;

            /** @var array $version Параметры конфигурации версии */
            $version = require($versionFile);
            if (empty($version)) continue;

            $name = $install['name'];
            $desc = $install['description'];

            $install['version'] = $version['version'] ?? '1.0';
            if ($component === self::CMP_WIDGET)
                $install['has_settings'] = file_exists($path . DS . 'src' . DS . 'Settings' . DS . 'Settings.php');
            else
            if ($component === self::CMP_PLUGIN)
                $install['has_settings'] = file_exists($path . DS . 'src' . DS . 'Settings' . DS . 'Settings.php');
            else
                $install['has_settings'] = file_exists($path . DS . 'src' . DS . 'Controller' . DS . 'Settings.php');

            // файл локализации компонента
            $languageFile = $path . DS . 'lang' . DS . 'text-' . $locale . '.php';
            if (file_exists($languageFile)) {
                $localize = require($languageFile);
                if ($localize) {
                    $name = $localize['{name}'] ?? $name;
                    $desc = $localize['{description}'] ?? $desc;
                }
            }

            // файл SQL-запросов
            $queriesFile = $path . DS . 'src' . DS . 'Installer' . DS . 'Queries.php';
            if (!file_exists($queriesFile)) {
                $queriesFile = null;
            }

            // файл значка компонента
            $iconFile = $path . DS . 'assets' . DS . 'images' . DS . 'icon.svg';
            if (file_exists($iconFile))
                $iconUrl = $baseUrl . '/' . $componentId . '/assets/images/icon.svg';
            else
                $iconUrl = $iconNone;

            $items[] = [
                'name'       => $name,
                'desc'       => $desc,
                'icon'       => $iconUrl,
                'message'    => null,
                'queries'    => $queriesFile,
                'assembled'  => false,
            ];

            if ($component === self::CMP_MODULE)
                $row = $this->getModuleRow($install, $uniqid);
            else
            if ($component === self::CMP_EXTENSION)
                $row = $this->getExtensionRow($install, $uniqid);
            else
            if ($component === self::CMP_WIDGET)
                $row = $this->getWidgetRow($install, $uniqid);
            else
            if ($component === self::CMP_PLUGIN)
                $row = $this->getPluginRow($install, $uniqid);
            else
                $row = null;

            if ($row) {
                $rows[$componentId] = $row;

                // разрешения определяющие полный доступ
                $allowed = $this->getAllowedPermissions($install['permissions'] ?? []);
                if ($allowed) {
                    $perms[] = ['id' => $row['id'], 'permissions' => $allowed];
                }
            }
        }
        return ['items' => $items, 'rows' => $rows, 'permissions' => $perms];
    }

    /**
     * Возвращает права доступа (разрешения) для Супер администратора.
     * 
     * Результат должен иметь вид: 'any,info,settings'
     * 
     * @param array $array Права доступа (разрешения) к компоненту, например: `['any', 'read', 'write', ...]`.
     * 
     * @return string|null
     */
    protected function getAllowedPermissions(array $array): ?string
    {
        $allowed = [];
        if (in_array('any', $array)) {
            $allowed[] = 'any';
        }
        // доступ к расширениям
        if (in_array('extension', $array)) {
            $allowed[] = 'extension';
        }
        if (in_array('info', $array)) {
            $allowed[] = 'info';
        }
        if (in_array('settings', $array)) {
            $allowed[] = 'settings';
        }
        return $allowed ? implode(',', $allowed) : null;
    }

    /**
     * Возвращает атрибуты записи модуля для добавления в базу данных.
     *
     * @param array $config Параметры конфигурации модуля.
     * @param int $uniqid Уникальный идентификатор записи в базе данных.
     * 
     * @return array
     */
    public function getModuleRow(array $config, int $uniqid): array
    {
        return [
            'id'           => $uniqid,
            'module_id'    => $config['id'],
            'module_use'   => $config['use'] ?? null,
            'name'         => $config['name'],
            'description'  => $config['description'],
            'namespace'    => $config['namespace'],
            'path'         => $config['path'],
            'route'        => $config['route'],
            'enabled'      => 1,
            'expandable'   => isset($config['expandable']) ? (int) $config['expandable'] : 0,
            'has_info'     => 1,
            'has_settings' => (int) $config['has_settings'],
            'permissions'  => isset($config['permissions']) ? implode(',', $config['permissions']) : null,
            'version'      => $config['version'] ?? '1.0',
            '_lock'        => (int) isset($this->locked['modules'][$config['id']])
        ];
    }

    /**
     * Возвращает атрибуты записи расширения модуля для добавления в базу данных.
     *
     * @param array $config Параметры конфигурации расширения модуля.
     * @param int $uniqid Уникальный идентификатор записи в базе данных.
     * 
     * @return array
     */
    public function getExtensionRow(array $config, int $uniqid): array
    {
        // расширение не может существовать без модуля
        if (isset($config['moduleId']))
            $module = $this->modules['rows'][$config['moduleId']] ?? null;
        else
            $module = null;
        // index, desk и menu неизвестно для чего
        return [
            'id'           => $uniqid,
            'module_id'    => $module ? $module['id'] : null,
            'extension_id' => $config['id'],
            'name'         => $config['name'],
            'description'  => $config['description'],
            'namespace'    => $config['namespace'],
            'path'         => $config['path'],
            'route'        => $config['route'],
            'enabled'      => 1,
            //'expandable'   => isset($config['expandable']) ? (int) $config['expandable'] : 0,
            'has_info'     => 1,
            'has_settings' => (int) $config['has_settings'],
            'permissions'  => isset($config['permissions']) ? implode(',', $config['permissions']) : null,
            'version'      => $config['version'] ?? '1.0',
            '_lock'        => (int) isset($this->locked['extensions'][$config['id']])
        ];
    }

    /**
     * Возвращает атрибуты записи виджета для добавления в базу данных.
     *
     * @param array $config Параметры конфигурации виджета.
     * @param int $uniqid Уникальный идентификатор записи в базе данных.
     * 
     * @return array
     */
    public function getWidgetRow(array $config, int $uniqid): array
    {
        return [
            'id'           => $uniqid,
            'widget_id'    => $config['id'],
            'widget_use'   => $config['use'],
            'category'     => $config['category'] ?? null,
            'name'         => $config['name'],
            'description'  => $config['description'],
            'namespace'    => $config['namespace'],
            'path'         => $config['path'],
            'enabled'      => 1,
            'has_settings' => (int) $config['has_settings'],
            'version'      => $config['version'] ?? '1.0',
            '_lock'        => (int) isset($this->locked['widgets'][$config['id']])
        ];
    }

    /**
     * Возвращает атрибуты записи плагина для добавления в базу данных.
     *
     * @param array $config Параметры конфигурации плагина.
     * @param int $uniqid Уникальный идентификатор записи в базе данных.
     * 
     * @return array
     */
    public function getPluginRow(array $config, int $uniqid): array
    {
        return [
            'id'           => $uniqid,
            'plugin_id'    => $config['id'],
            'owner_id'     => $config['ownerId'],
            'category'     => $config['category'] ?? null,
            'name'         => $config['name'],
            'description'  => $config['description'],
            'namespace'    => $config['namespace'],
            'path'         => $config['path'],
            'enabled'      => 1,
            'has_settings' => (int) $config['has_settings'],
            'version'      => $config['version'] ?? '1.0',
            '_lock'        => (int) isset($this->locked['plugins'][$config['id']])
        ];
    }
}
