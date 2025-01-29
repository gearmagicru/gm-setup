<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\CommonChoice;

use Gm\Setup\SetupStep;

/**
 * Шаг установки "Добро пожаловать".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\CommonChoice
 * @since 1.0
 */
class StepWelcome extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'welcome';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'common/welcome';

    /**
     * {@inheritdoc}
     */
    protected function initAction(): void
    {
        if (!$this->hasAction()) {
            // чтобы для текущего шага не было выбора вида установки
            // даже если сделали переход "Назад" (с выбором установки)
            // удалить выбор предыдущих шагов
            $this->state->reset();
        }

        parent::initAction();
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        $language = $_POST['language'] ?? null;
        if (empty($language)) {
            $this->addError($this->t('You need to select a language'));
        } else
            $this->state->language = $language;

        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Welcome');
    }

    /**
     * Выполняет действие "Welcome" (выбор языка и переход к следующему шагу).
     * 
     * @return void
     */
    public function welcomeAction()
    {
        if ($this->validate()) {
            // отметить завершение шага
            $this->complete();
            // обновить изменения сделанные шагом
            if ($this->updateState()) {
                header('Location: ' . $this->installer->makeUrl('check'));
            }
        }
    }
}