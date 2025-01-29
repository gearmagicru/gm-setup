<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup;

use Gm\Helper\Html;
use Gm\Installer\Installer;
use Gm\Installer\InstallerStep;

/**
 * Шаг установки редакции веб-приложения.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup
 * @since 1.0
 */
class SetupStep extends InstallerStep
{
    /**
     * Установщик.
     * 
     * @var Installer
     */
    public Installer $installer;

    /**
     * {@inheritdoc}
     */
    public string $lockName = '.setup';

    /**
     * Обновить (сохранить) состояние шагов установки.
     * 
     * @return bool Возвращает значение `false`, если возникла ошибка.
     */
    public function updateState(): bool
    {
        /** @var bool $result */
        $result = $this->state->save();
        if (!$result) {
            $this->addError('Unable to write data to setup session file');  // Невозможно записать данные в файл сессии установки
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function showMessage(string $message = '', ?string $title = '', string $type = ''): string
    {
        // если последняя ошибка
        if ($message === '') {
            /** @var null|array $msg Последнее сообщение */
            if ($msg = $this->getMessage()) {
                $message = $msg['message'];
                $title   = $msg['title'];
                $type    = $msg['type'];
            } else
                return '';
        }

        if ($title === '') {
            if ($type) {
                switch ($type) {
                    case 'danger': $title = $this->t('Error'); break;
                    case 'warning': $title = $this->t('Warning'); break;
                }
            } else
                $type = 'danger';
        }
        if ($title) {
            $message = '<div class="alert__title">' . $title . '</div> ' . $message;
        }
        return Html::tag('div', $message, ['class' => 'alert alert-' . $type]);
    }

    /**
     * @param string $str
     * @param int $from
     * @param int $to
     * 
     * @return bool
     */
    public static function strInRange(string $str, int $from, int $to = 0): bool
    {
        $length =  mb_strlen($str);
        if ($to) {
            if ($from !== 0)
                return $length > $from && $length < $to;
            else
                return $length < $to;
        } else
            return $length > $from;
    }
}