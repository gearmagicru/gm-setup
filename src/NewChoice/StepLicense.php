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
 * Шаг установки "Лицензионное соглашение".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepLicense extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'license';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/license';

    /**
     * Возвращает имя лицензионного соглашения.
     * 
     * @param string|null $locale Имя локализации, например: 'ru_RU', 'en_GB', если значение 
     *     '', то имя файла не будет содержать локализацию.
     * 
     * @return string
     */
    protected function getLicenseFilename(?string $locale = null): string
    {
        if ($locale === null) {
            $locale = $this->installer->getLocale();
        }
        return 'license' . ($locale ? '-' . $locale : '') . '.html';
    }

    /**
     * Возвращает абсолютный путь к файлам лицензии.
     * 
     * @return string
     */
    protected function getLicensePath(): string
    {
        return $this->installer->getPath() . DS . 'license';
    }

    /**
     * Выводит лицензионное соглашение.
     * 
     * @return void
     */
    public function showLicense(): void
    {
        /** @var string $path Путь к файлам лицензий */
        $path = $this->getLicensePath();
        /** @var string $filename Имя файла лицензии */
        $filename = $path . DS . $this->getLicenseFilename();
        if (!file_exists($filename)) {
            // имя файла лицензии по умолчанию
            $filename = $path . DS . $this->getLicenseFilename('');
            if (!file_exists($filename)) {
                $this->addError(
                    $this->t('Unable to load license agreement file "%s"', [$filename])
                );
                return;
            }
        }

        /** @var false|string $license */
        $license = file_get_contents($filename, true);
        if (empty($license)) {
            $this->addError(
                $this->t('Unable to load license agreement file "%s"', [$filename])
            );
            return;
        }

        /** @var string $language */
        $language = $this->installer->getLanguage();
        /** @var \Gm\Version\AppVersion $version */
        $version = $this->installer->getAppVersion();
        echo str_replace('{application}', $language === 'ru' ? $version->originalName : $version->name, $license);
    }

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
        // согласиться с лицензионным соглашением
        $this->state->licenseApply = $_POST['licenseApply'] ?? false;

        // если флаг не выбран
        if (!$this->state->licenseApply) {
                $this->addWarning(
                    $this->t('To continue you must accept the license agreement')
                );
        }
        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('License agreement');
    }

    /**
     * Выполняет действие "License" (сохраняет лицензионный ключ).
     * 
     * @return void
     */
    public function licenseAction(): void
    {
        if ($this->validate()) {
            // отметить завершение шага
            $this->complete();
            // обновить изменения сделанные шагом
            if ($this->updateState()) {
                header('Location: ' . $this->installer->makeUrl('new:registration'));
            }
        }
    }
}