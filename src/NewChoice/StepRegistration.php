<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Gm\Setup\SetupStep;

/**
 * Шаг установки "Регистрация веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepRegistration extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'registration';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/registration';

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
    protected function validate(): bool
    {
        // указать лицензионный ключ после установки
        $this->state->licenseKeyAfter = isset($_POST['licenseKeyAfter']);

        // если флаг не выбран
        if (!$this->state->licenseKeyAfter) {
            $this->state->licenseKey = $_POST['licenseKey'] ?? '';
            if (empty($this->state->licenseKey)) {
                $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('License Key')]));
            }
        } else
            $this->state->licenseKey = '';
        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Web application registration');
    }

    /**
     * Выполняет действие "Registration" (сохраняет лицензионный ключ).
     * 
     * @return void
     */
    public function registrationAction(): void
    {
        if ($this->validate()) {
            // отметить завершение шага
            $this->complete();
            // обновить изменения сделанные шагом
            if ($this->updateState()) {
                header('Location: ' . $this->installer->makeUrl('new:db'));
            }
        }
    }
}