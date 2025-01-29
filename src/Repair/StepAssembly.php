<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\Repair;

use Exception;
use Gm\Db\QueriesMap;
use Gm\Setup\SetupStep;
use Gm\Setup\Components;

/**
 * Шаг установки "Обновление параметров установленных компонентов".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\Repair
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
    public string $viewName = 'repair/assembly';

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
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('common:choice');
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        parent::initParams();

        $this->editionMap = $this->installer->getQueriesMap([
            'autoload' => true,
            // параметры которые будут доступны в файле карты SQL-запросов
            'params' => ['language' => $this->state->language]
        ]);

        // если карта загружена
        if ($this->editionMap->loaded) {
            $this->components = new Components([
                'installer'    => $this->installer,
                'modulesId'    => $this->editionMap->getVar('modules'),
                'extensionsId' => $this->editionMap->getVar('extensions'),
                'widgetsId'    => $this->editionMap->getVar('widgets')
            ]);

            if (!$this->hasAction()) {
                $this->state->modules    = $this->components->findModules();
                $this->state->extensions = $this->components->findExtensions();
                $this->state->widgets    = $this->components->findWidgets();
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
        $this->params['collapseExtensions'] = $this->collapseExtensions;
        $this->params['collapseModules'] = $this->collapseModules;
        $this->params['collapseWidgets'] = $this->collapseWidgets;
        $this->params['isAppInstalled'] = $this->isAppInstalled();
    }

    /**
     * Проверяет, установлено ли ли веб-приложение.
     * 
     * @return bool
     */
    protected function isAppInstalled(): bool
    {
        return file_exists(BASE_PATH . CONFIG_PATH . DS . '.application.php');
    }

    /**
     * Выполняет обновление модулей веб-приложения.
     * 
     * @return bool
     */
    protected function assemblyModules(): bool
    {
        /** @var array $modules Все найденные модули */
        $modules = $this->state->modules ?? [];

        // сбрасываем статус сборки модулей
        foreach ($modules['items'] as $moduleId => &$module) {
            $module['assembled'] = true;
        }

        // развернуть список модулей
        $this->collapseModules = false;
        // обновить состояние установки модулей
        $this->state->modules = $modules;
        return true;
    }

    /**
     * Выполняет обновление расширений модулей веб-приложения.
     * 
     * @return bool
     */
    protected function assemblyExtensions(): bool
    {
        /** @var array $extensions Все найденные расширения */
        $extensions = $this->state->extensions ?? [];

        // сбрасываем статус сборки расширений модулей
        foreach ($extensions['items'] as $extensionId => &$extension) {
            $extension['assembled'] = true;
        }

        // развернуть список модулей
        $this->collapseExtensions = false;
        // обновить состояние установки расширений модулей
        $this->state->extensions = $extensions;
        return true;
    }

    /**
     * Выполняет обновление виджетов веб-приложения.
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
     * Выполняет обновление редакции веб-приложения.
     * 
     * @return bool
     */
    protected function assemblyEdition(): bool
    {
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
     * Выполняет действие "Assembly" (обновление параметров).
     * 
     * @return bool
     */
    protected function assemblyAction(): bool
    {
        // обновление модулей
        if (!$this->assemblyModules()) {
            $this->addError($this->t('Errors occurred while installing modules'));
            $this->collapseExtensions = true;
            $this->collapseWidgets = true;
            return false;
        }

        // обновление расширений модулей
        if (!$this->assemblyExtensions()) {
            $this->addError($this->t('Errors occurred during the installation of module extensions'));
            $this->collapseWidgets = true;
            return false;
        }

        // обновление виджетов
        if (!$this->assemblyWidgets()) {
            $this->addError($this->t('Errors occurred while installing widgets'));
            return false;
        }

        // обновление редакции
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