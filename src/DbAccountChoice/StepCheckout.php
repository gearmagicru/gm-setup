<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\DbAccountChoice;

use Gm\Setup\SetupStepCheckout;
use Gm\Installer\AppConfigFile;

/**
 * Шаг установки "Контроль доступа к файлам веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\DbAccountChoice
 * @since 1.0
 */
class StepCheckout extends SetupStepCheckout
{
    /**
     * {@inheritdoc}
     */
    public string $viewName = 'dbaccount/checkout';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('dbaccount:dbcharset');
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        parent::initParams();

        if (!$this->hasAction()) {
            $this->checkout = [
                $this->checkDir(CONFIG_PATH, true, '0750', 'directory of web application configuration files', [
                    $this->checkConfigFile('.database.php', true, '0644', 'database connection configuration file'),
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
        return true;
    }

    /**
     * Выполняет действие "Next" (выбор следующего шага).
     * 
     * @return void
     */
    public function nextAction(): void
    {
        // создание файлов конфигурации веб-приложения
        if ($this->createConfigFiles()) {
            // отметить завершение шага
            $this->complete();
            // обновить изменения сделанные шагом
            if ($this->updateState()) {
                header('Location: ' . $this->installer->makeUrl('dbaccount:finish'));
            }
        }
    }
}