<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Gm\Setup\SetupStepCheckout;

/**
 * Шаг установки "Контроль доступа к файлам веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepCheckout extends SetupStepCheckout
{
    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/checkout';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:dbcharset');
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        parent::initParams();

        if (!$this->hasAction()) {
            $this->checkout = [
                $this->checkDir(DS . 'app', true, '0644', 'directory of web application files'),
                $this->checkDir(DS . 'bootstrap', true, '0644', 'directory of web application download files'),
                $this->checkDir(DS . 'lang', true, '0644', 'directory for localizing web application files'),
                $this->checkDir(DS . 'public', true, '0644', 'directory site files'),
                $this->checkDir(DS . 'runtime', true, '0644', 'directory of web application temporary files'),
                $this->checkDir(DS . 'views', true, '0644', 'directory of web application component base templates'),
                $this->checkDir(VENDOR_PATH, true, '0644', 'directory of installed PHP libraries'),
                $this->checkDir(MODULE_PATH, true, '0644', 'directory of web application components'),
                $this->checkDir(CONFIG_PATH, true, '0750', 'directory of web application configuration files', [
                    $this->checkConfigFile('.widgets.php', false, '0644', 'installed widgets configuration file'),
                    $this->checkConfigFile('.modules.php', false, '0644', 'installed modules configuration file'),
                    $this->checkConfigFile('.extensions.php', false, '0644', 'configuration file of installed module extensions'),
                    $this->checkConfigFile('.shortcodes.php', false, '0644', 'shortcode manager configuration file (shortcodes)'),
                    $this->checkConfigFile('.database.sample.php', false, '0644', 'database connection configuration file'),
                    $this->checkConfigFile('.application.sample.php', false, '0644', 'web application configuration file'),
                    $this->checkConfigFile('.license.sample.php', false, '0644', 'license key file'),
                    $this->checkConfigFile('.unified.php', false, '0644', 'web application unified configuration file'),
                    $this->checkConfigFile('.services.php', false, '0644', 'service manager configuration file'),
                    $this->checkConfigFile('.language.php', false, '0644', 'language configuration file'),
                    $this->checkConfigFile('.filesystem.php', false, '0644', 'file system manager configuration file for Flysystem PHP package'),
                    $this->checkConfigFile('.mimes.php', false, '0644', 'MIME type configuration file'),
                ]),
                $this->checkDir(CONFIG_PATH . DS . BACKEND, true, '0644', 'control panel configuration file directory', [
                    $this->checkConfigFile(BACKEND . DS . '.router.php', false, '0644', 'control panel routing configuration file'),
                    $this->checkConfigFile(BACKEND . DS . '.services.php', false, '0644', 'control panel service manager configuration file'),
                ]),
                $this->checkDir(CONFIG_PATH . DS . FRONTEND, true, '0644', 'site configuration file directory', [
                    $this->checkConfigFile(FRONTEND . DS . '.router.php', false, '0644', 'site routing configuration file'),
                    $this->checkConfigFile(FRONTEND . DS . '.services.php', false, '0644', 'site service manager configuration file'),
                ]),
                $this->checkDir(CONFIG_PATH . DS . CONSOLE, false, '0644', 'console configuration files directory', [
                    $this->checkConfigFile(CONSOLE . DS . '.services.php', false, '0644', 'console service manager configuration file'),
                ])
            ];
        } else
            $this->checkout = [];
        $this->params['checkout'] = $this->checkout;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Web application files checkout');
    }

    /**
     * Выполняет действие "Next" (выбор следующего шага).
     * 
     * @return void
     */
    public function nextAction(): void
    {
        // отметить завершение шага
        $this->complete();
        // обновить изменения сделанные шагом
        if ($this->updateState()) {
            header('Location: ' . $this->installer->makeUrl('new:assembly'));
        }
    }
}