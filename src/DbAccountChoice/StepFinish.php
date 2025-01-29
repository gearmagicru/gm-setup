<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\DbAccountChoice;

use Gm;
use Exception;
use Gm\Helper\Url;
use Gm\Setup\SetupStep;

/**
 * Шаг установки "Завершение установки".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\DbAccountChoice
 * @since 1.0
 */
class StepFinish extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'finish';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'dbaccount/finish';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('dbaccount:checkout');
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Web application files checkout');
    }

    /**
     * Выполняет действие "gotoPanel" (переход к Панели управления).
     * 
     * @return void
     */
    protected function gotoPanelAction(): void
    {
        // если попытка блокировать установщик не удалась
        if (!$this->installer->makeInaccessible()) {
            $this->addError(
                $this->t('Unable to delete directory "%s" to stop the installer. Do it manually.', [$this->installer->getLockName()])
            );
            return;
        }
        // сброс состояние установки
        $this->state->reset();

        try {
            /** @var \Gm\Mvc\Application $app */
            $app = $this->installer->getApp();

            if (Gm::alias('@backend') === '') {
                throw new Exception('not found');
            }
        } catch (Exception $exception) {
            $this->addError($exception->getMessage());
            return;
        }

        header('Location: ' . Url::home() . '/' . Gm::alias('@backend'));
    }

    /**
     * Выполняет действие "gotoSite" (переход на сайт).
     * 
     * @return void
     */
    protected function gotoSiteAction(): void
    {
        // если попытка блокировать установщик не удалась
        if (!$this->installer->makeInaccessible()) {
            $this->addError(
                $this->t('Unable to delete directory "%s" to stop the installer. Do it manually.', [$this->installer->getLockName()])
            );
            return;
        }
        // сброс состояние установки
        $this->state->reset();

        header('Location: ' . Url::home());
    }
}