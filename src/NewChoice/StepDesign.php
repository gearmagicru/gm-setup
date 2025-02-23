<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Gm\Helper\Url;
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
    protected function applyThemeDemo(): void
    {
        /** @var \Gm\Mvc\Application $app */
        $app = $this->installer->getApp();

        /** @var BaseObject|null $model */
        /*$model = $app->modules->getModel('Article1', 'gm.be.articles');
        if ($model) {
            $model->header = 'dddddddddddddddd';
            $model->save();
        }*/
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