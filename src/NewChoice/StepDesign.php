<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Gm\Config\Config;
use Gm\Setup\SetupStep;

/**
 * Шаг установки "Дизайн веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepDesign extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'design';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/design';


    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:assembly');
    }

    /**
     * Возвращает все темы сайта и Панели управления.
     * 
     * @param string $side Сайт или Панель управления (`FRONTEND`, `BACKEND`).
     * 
     * @return array
     */
    protected function getThemes(string $side): array
    {
        /** @var \Gm\Mvc\Application $app */
        $app = $this->installer->getApp();
        /** @var \Gm\Theme\Theme $theme */
        if ($side === FRONTEND)
            $theme  = $app->createFrontendTheme();
        else
            $theme  = $app->createBackendTheme();
        return $theme->find();
    }

    /**
     * Возвращает параметры для указанной темы Панели управления.
     * 
     * @param string $theme Имя выбранной темы.
     * 
     * @return array|false Возвращает значение `false` если параметры по указанной 
     *     теме не найдены.
     */
    protected function getFeThemeParams(string $theme): array|false
    {
        if (empty($this->state->feThemes)) {
            return false;
        }
        foreach ($this->state->feThemes as $params) {
            if ($params['name'] === $theme) {
                return $params;
            }
        }
        return false;
    }

    /**
     * Возвращает параметры для указанной темы сайта.
     * 
     * @param string $theme Имя выбранной темы.
     * 
     * @return array|false Возвращает значение `false` если параметры по указанной 
     *     теме не найдены.
     */
    protected function getBeThemeParams(string $theme): array|false
    {
        if (empty($this->state->beThemes)) {
            return false;
        }
        foreach ($this->state->beThemes as $params) {
            if ($params['name'] === $theme) {
                return $params;
            }
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        parent::initParams();

        // согласиться с демоданными
        $this->state->applyThemeDemo = ($_POST['applyThemeDemo'] ?? false) === 'on';
        // выбранная тема сайта
        $this->state->feTheme = $_POST['feTheme'] ?? null;
        // выбранная тема Панели управления
        $this->state->beTheme = $_POST['beTheme'] ?? null;
        // установленные темы сайта
        $this->state->feThemes = $this->getThemes(FRONTEND);
        // установленные темы Панели управления
        $this->state->beThemes = $this->getThemes(BACKEND);
    }

    /**
     * Наполнить демонстрационными данными.
     * 
     * @return void
     */
    protected function applyThemeDemo(): bool
    {
        /** @var \Gm\Mvc\Application $app */
        $app = $this->installer->getApp();

        /** @var null|\Gm\Theme\Theme $theme */
        $theme = $app->createThemeBySide('frontend');
        /** @var array|false Параметры выбранной темы $themeParams */
        $themeParams = $this->getFeThemeParams($this->state->feTheme);
        if ($themeParams === false) {
            $this->addError('Unable to determine theme "' . $this->state->feTheme . '" parameters');
            return false;
        }
        // т.к. возможно тема еще не установлена, то добавляем найденную тему
        // в доступные (иначе методы $theme не будет работать)
        $theme->addAvailable($this->state->feTheme, $themeParams);
        // если есть демоданные для сайта
        if ($theme->hasPreview($this->state->feTheme)) {
            $packageFile = $theme->getPreviewFilename($this->state->feTheme);

            try {
                $import = new \Gm\Import\Import();
                $import->runPackage($packageFile);
                /** @var \Gm\Import\Parser\AbstractParser $parser */
                $parser = $import->getParser();
                // если была ошибка при разборе
                if ($parser->hasErrors()) {
                    $this->addError($parser->getError());
                    return false;
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
                return false;
            }
        }

        /** @var null|\Gm\Theme\Theme $theme */
        $theme = $app->createThemeBySide('backend');
        /** @var array|false Параметры выбранной темы $themeParams */
        $themeParams = $this->getBeThemeParams($this->state->beTheme);
        if ($themeParams === false) {
            $this->addError('Unable to determine theme "' . $this->state->beTheme . '" parameters');
            return false;
        }
        // т.к. возможно тема еще не установлена, то добавляем найденную тему
        // в доступные (иначе методы $theme не будет работать)
        $theme->addAvailable($this->state->beTheme, $themeParams);
        // если есть демоданные для Панели управления
        if ($theme->hasPreview($this->state->beTheme)) {
            $packageFile = $theme->getPreviewFilename($this->state->beTheme);

            try {
                $import = new \Gm\Import\Import();
                $import->runPackage($packageFile);
                /** @var \Gm\Import\Parser\AbstractParser $parser */
                $parser = $import->getParser();
                // если была ошибка при разборе
                if ($parser->hasErrors()) {
                    $this->addError($parser->getError());
                    return false;
                }
            } catch (\Exception $e) {
                $this->addError($e->getMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        $feTheme = $_POST['feTheme'] ?? null;
        if (empty($feTheme)) {
            $this->addWarning($this->t('You need to select the website theme'));
            return false;
        }
        $beTheme = $_POST['beTheme'] ?? null;
        if (empty($beTheme)) {
            $this->addWarning($this->t('You need to select the Control Panel theme'));
            return false;
        }
        $this->state->feTheme = $feTheme;
        $this->state->beTheme = $beTheme;
        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Choosing a Web Application design');
    }

    /**
     * Создаёт унифицированный файл конфигурации веб-приложения.
     * 
     * @return bool
     */
    protected function createConfigFiles(): bool
    {
        /** @var Config $unified */
        $unified = new Config(BASE_PATH . CONFIG_PATH . DS . '.unified.php', true);

        // тема сайта
        $frontendTheme = [
            'side'      => FRONTEND,
            'default'   => $this->state->feTheme,
            'available' => []
        ];
        foreach ($this->state->feThemes as $theme) {
            $frontendTheme['available'][$theme['name']] = [
                'name'      => $theme['name'],
                'localPath' => $theme['localPath']
            ];
        }
        $unified->frontendTheme = $frontendTheme;

        // тема Панели управления
        $backendTheme = [
            'side'      => BACKEND,
            'default'   => $this->state->beTheme,
            'available' => []
        ];
        foreach ($this->state->beThemes as $theme) {
            $backendTheme['available'][$theme['name']] = [
                'name'      => $theme['name'],
                'localPath' => $theme['localPath']
            ];
        }
        $unified->backendTheme = $backendTheme;

        if (!$unified->save()) {
            $this->addError(
                $this->t('Cannot write to app configuration file "%s"', [$unified->getFilename()]),
                $this->t('File write error')
            );
            return false;
        }
        return true;
    }

    /**
     *  Выполняет действие "Design" (устанавливает темы).
     * 
     * @return void
     */
    public function designAction(): void
    {
        if ($this->validate()) {
            // если применяются демонстрационные данные шаблона
            if ($this->state->applyThemeDemo) {
                if (!$this->applyThemeDemo()) return;
            }

            // создание файла конфигурации веб-приложения
            if ($this->createConfigFiles()) {
                // отметить завершение шага
                $this->complete();
                // обновить изменения сделанные шагом
                if ($this->updateState()) {
                    header('Location: ' . $this->installer->makeUrl('new:info'));
                }
            }
        }
    }
}
