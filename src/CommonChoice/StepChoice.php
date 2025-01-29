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
 * Шаг установки "Выбор установки".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\CommonChoice
 * @since 1.0
 */
class StepChoice extends SetupStep
{
    /**
     * Доступные выборы установки.
     * 
     * @var array
     */
    public array $availableChoices = [
        'new'       => ['next' => 'new:license'],
        'dbaccount' => ['next' => 'dbaccount:db'],
        'repair'    => ['next' => 'repair:update'],
    ];

    /**
     * {@inheritdoc}
     */
    public string $name = 'choice';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'common/choice';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('common:check');
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        $choice = $_POST['choice'] ?? null;
        if (empty($choice)) {
            $this->addWarning($this->t('You need to select the installation type'));
            return false;
        }
        if (!isset($this->availableChoices[$choice])) {
            $this->addWarning($this->t('You need to select the installation type'));
            return false;
        }
        $this->state->choice = $choice;
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Installation selection');
    }

    /**
     *  Выполняет действие "Choice" (выбор установки).
     * 
     * @return void
     */
    public function choiceAction(): void
    {
        if ($this->validate()) {
            // отметить завершение шага
            $this->complete();
            // обновить изменения сделанные шагом
            if ($this->updateState()) {
                /** @var null|string $choice */
                $choice = $this->availableChoices[$this->state->choice]['next'] ?? null;
                if ($choice) {
                    header('Location: ' . $this->installer->makeUrl($choice));
                }
            }
        }
    }

}