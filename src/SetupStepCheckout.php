<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup;

use Gm\Helper\Html;
use Gm\Setup\SetupStep;
use Gm\Installer\AppConfigFile;
use Gm\Filesystem\Filesystem AS Fs;

/**
 * Базовй класс шага установки "Контроль доступа к файлам веб-приложения".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup
 * @since 1.0
 */
class SetupStepCheckout extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'checkout';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/checkout';

    /**
     * Имя тега в результате проверки прав доступа файла или каталога.
     * 
     * @var string
     */
    public string $itemTag = 'span';

    /**
     * Имя CSS класса удачной проверки прав доступа.
     * 
     * @var string
     */
    public string $itemTagClsCorrect = 'correct';

    /**
     * Имя CSS класса провала проверки прав доступа.
     * 
     * @var string
     */
    public string $itemTagClsFailure = 'failure';

    /**
     * Файлы и каталоги с результатами проверки.
     * 
     * @var array
     */
    protected array $checkout = [];

    /**
     * Была ли успешно выполнена проверка.
     * 
     * @see StepCheckout::isChecked()
     * 
     * @var bool
     */
    protected bool $checked = true;

    /**
     * Возвращает значение, указывающие, была ли успешно выполнена проверка.
     * 
     * @return bool
     */
    public function isChecked(): bool
    {
         return $this->checked;
    }

    /**
     * Выполняет проверку каталога.
     * 
     * @param string $name Название каталога (относитель базового пути к сайту BASE_PATH).
     * @param bool $allowedWrite Проверить каталог на запись файла (по умолчанию `true`).
     * @param string $requiredPerms Требуемые права доступа (по умолчанию '0750').
     * @param array $items Массив файлов каталога, которым была выполнена проверка (по умолчанию `[]`).
     * 
     * @return array
     */
    public function checkDir(
        string $name, bool $allowedWrite = true, string $requiredPerms = '0750', string $desc = '', array $items = []
    ): array
    {
        $dir = BASE_PATH . $name;

        $messages = []; // сообщения
        $perms = ''; // права доступа
        $correct = false; // соответствие прав доступа требуемым
        
        // если каталог существует
        if (file_exists($dir)) {
            $perms = Fs::permissions($dir, true, false);
            // невозможно проверить права доступа
            if ($perms !== false) {
                // права доступа не соответствуют требуемым
                if (OS_WINDOWS)
                    $correct = true;
                else
                    $correct = $requiredPerms === $perms;
                if (!$correct) {
                    $messages[] = [
                        'message' => $this->t('Need to set permissions "%s" to directory "%s".', [$requiredPerms, $name]),
                        'title'   => null,
                        'type'    => 'warning'
                    ];
                }
                if ($allowedWrite) {
                }
            } else {
                $this->checked = false;
                $messages[] = [
                    'message' => $this->t('Unable to determine directory permissions "%s".', [$dir]),
                    'title'   => null,
                    'type'    => 'error'
                ];
            }
        } else {
            $this->checked = false;
            $messages[] = [
                'message' => $this->t('Directory "%s" does not exist.', [$dir]),
                'title'   => null,
                'type'    => 'error'
            ];
        }
        return [
            'name'     => $name,
            'fullname'  => $dir,
            'messages' => $messages,
            'desc'     => $this->t($desc),
            'rperms'   => $requiredPerms,
            'perms'    => Html::tag(
                $this->itemTag,
                $perms, 
                ['class' => $correct ? $this->itemTagClsCorrect : $this->itemTagClsFailure]
            ), 
            'items' => $items
        ];
    }

    /**
     * Выполняет проверку файла.
     * 
     * @param string $name Название файла (будет добавлен путь к сайту BASE_PATH).
     * @param bool $allowedWrite Проверить каталог на запись файла (по умолчанию `true`).
     * @param string $requiredPerms Требуемые права доступа (по умолчанию '0644').
     * @param string $desc Описание файла (по умолчанию '').
     * 
     * @return array
     */
    public function checkFile(string $name, bool $allowedWrite = true, string $requiredPerms = '0644', string $desc = ''): array
    {
        $filename = BASE_PATH . $name;

        $messages = []; // сообщения
        $perms = ''; // права доступа
        $correct = false; // соответствие прав доступа требуемым
        
        // если файл существует
        if (file_exists($filename)) {
            $perms = Fs::permissions($filename, true, false);
            // невозможно проверить права доступа
            if ($perms !== false) {
                // права доступа не соответствуют требуемым
                if (OS_WINDOWS)
                    $correct = true;
                else
                    $correct = $requiredPerms === $perms;
                if (!$correct) {
                    $messages[] = [
                        'message' => $this->t('Need to set permissions "%s" to file "%s".', [$requiredPerms, $name]),
                        'title'   => null,
                        'type'    => 'warning'
                    ];
                }
                if ($allowedWrite) {
                    $configFile = new AppConfigFile($name);
                    if ($configFile->sampleExists()) {
                        if (!$configFile->testWrite()) {
                            $this->checked = false;
                            $messages[] = [
                                'message' => $this->t('Error writing to file. Unable to create or write file, no permissions.'),
                                'title'   => null,
                                'type'    => 'error'
                            ];
                        }
                    } else {
                        $this->checked = false;
                        $messages[] = [
                            'message' => $this->t('File template "%s" not found for installation.', [$configFile->getSampleFilename()]),
                            'title'   => null,
                            'type'    => 'error'
                        ];
                    }
                }
            } else {
                $this->checked = false;
                $messages[] = [
                    'message' => $this->t('Unable to determine file permissions "%s".', [$filename]),
                    'title'   => null,
                    'type'    => 'error'
                ];
            }
        } else {
            $this->checked = false;
            $messages[] = [
                'message' => $this->t('File "%s" not found.', [$name]),
                'title'   => null,
                'type'    => 'error'
            ];
        }
        return [
            'name'     => $name,
            'fullname' => $filename,
            'messages' => $messages,
            'desc'     => $this->t($desc),
            'rperms'   => $requiredPerms,
            'perms'    => Html::tag(
                $this->itemTag,
                $perms, 
                ['class' => $correct ? $this->itemTagClsCorrect : $this->itemTagClsFailure]
            ),
            'items' => []
        ];
    }

    /**
     * Выполняет проверку файла конфигурации.
     * 
     * @see StepCheckout::checkFile()
     * 
     * @param string $name Название файла (будет добавлен путь к сайту BASE_PATH).
     * @param bool $allowedWrite Проверить каталог на запись файла (по умолчанию `true`).
     * @param string $requiredPerms Требуемые права доступа (по умолчанию '0644').
     * @param string $desc Описание файла (по умолчанию '').
     * 
     * @return array
     */
    public function checkConfigFile(string $name, bool $allowedWrite = true, string $requiredPerms = '0644', string $desc = ''): array
    {
        return $this->checkFile(CONFIG_PATH . DS . $name, $allowedWrite, $requiredPerms, $desc);
    }
}