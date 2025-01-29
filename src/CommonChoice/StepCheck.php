<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\CommonChoice;

use Gm\Helper\Html;
use Gm\Setup\SetupStep;

/**
 * Шаг установки "Предварительная проверка".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\CommonChoice
 * @since 1.0
 */
class StepCheck extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'check';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'common/check';

    /**
     * Имя тега в результате проверки параметров.
     * 
     * @var string
     */
    public string $itemTag = 'span';

    /**
     * Имя CSS класса удачной проверки параметров.
     * 
     * @var string
     */
    public string $itemTagClsCorrect = 'correct';

    /**
     * Имя CSS класса провала проверки параметров.
     * 
     * @var string
     */
    public string $itemTagClsFailure = 'failure';

    /**
     * Значение требуется - 'Включен'.
     * 
     * @var string
     */
    public string $msgLoaded = 'Loaded';

    /**
     * Значение требуется - 'Выключен'.
     * 
     * @var string
     */
    public string $msgNotLoaded = 'Not loaded';

    /**
     * Значение требуется - 'Установлен'.
     * 
     * @var string
     */
    public string $msgInstalled = 'Installed';

    /**
     * Значение требуется - 'Не установлен'.
     * 
     * @var string
     */
    public string $msgNotInstalled = 'Not installed';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('common:welcome');
    }

    /**
     * {@inheritdoc}
     */
    protected function initParams(): void
    {
        $this->msgLoaded = $this->t($this->msgLoaded);
        $this->msgNotLoaded = $this->t($this->msgNotLoaded);
        $this->msgInstalled = $this->t($this->msgInstalled);
        $this->msgNotInstalled = $this->t($this->msgNotInstalled);

        parent::initParams();

        if (!$this->hasAction())
            $this->params['checked'] = $this->check();
        else
            $this->params['checked'] = [];
    }

    /**
     * Возвращает версию веб-сервера Apache.
     * 
     * @return string
     */
    protected function getApacheVersion(): string
    {
        static $version;

        if ($version !== null) {
            return $version;
        }

        if (function_exists('apache_get_version')) {
            $version = apache_get_version();
        } else 
        if (isset($_SERVER['SERVER_SOFTWARE']))
            $version = $_SERVER['SERVER_SOFTWARE'];
        else
            $version = '';

        if ($version) {
            // Apache/2.0.55 Server ... => 2.0
            preg_match('/Apache\/(\d+\.\d+)/U', $version, $result);
            if (isset($result[1])) 
                $version = $result[1];
            // Apache/2 Server ... => 2
            else {
                preg_match('/Apache\/([0-9])/U', $version, $result);
                if (isset($result[1]))
                    $version = $result[1];
            }
        }
        if ($version === 'Apache' || $version === '') {
            $version = '2.?';
        }
        return $version;
    }

    /**
     * Проверяет версию PHP для устанавливаемого веб-приложения.
     * 
     * @return bool
     */
    protected function checkPHP(): bool
    {
        return version_compare(PHP_VERSION, REQUIRED_PHP_VERSION, '>=');
    }

    /**
     * Проверяет версию Apache для устанавливаемого веб-приложения.
     * 
     * @return bool
     */
    protected function checkApache(): bool
    {
        return version_compare($this->getApacheVersion(), REQUIRED_APACHE_VERSION, '>=');
    }

    /**
     * Возвращает массив проверенных параметров.
     * 
     * @return array
     */
    protected function check(): array
    {
        $isChecked = true;
        // проверка параметров
        $result = $this->checkParams([
            ['php'],
            ['apache'],
            ['extension', 'mysqli'],
            ['extension', 'session'],
            ['extension', 'json'],
            ['extension', 'mbstring'],
            ['extension', 'curl'],
            ['extension', 'intl'],
            ['extension', 'zip'],
            ['extension', 'gd'],
            ['extension', 'libxml'],
            ['extension', 'redis'],
            ['ini', 'short_open_tag', '1'],
            ['ini', 'max_execution_time'],
            ['ini', 'memory_limit'],
            ['ini', 'max_file_uploads'],
            ['ini', 'post_max_size'],
            ['ini', 'default_charset'],
            ['ini', 'allow_url_include', '0'],
            ['ini', 'allow_url_fopen', '1'],
            ['ini', 'opcache.enable', '1'],
            ['ini', 'date.timezone'],
        ], $isChecked);

        if (!$isChecked) {
            $this->addWarning($this->t('There are parameters that need to be corrected'));
        }
        return $result;
    }

    /**
     * Проверяет параметры.
     * 
     * @param array $params Проверяемые параметры.
     * @param bool $checked Результат проверки параметров.
     * 
     * @return array Возвращает HTML-разметку параметров.
     */
    public function checkParams(array $params, bool &$checked): array
    {
        $result = [];
        foreach ($params as  $param) {
            $type  = $param[0];
            $name  = $param[1] ?? $type;
            $value = $param[2] ?? null;

            // extension
            if ($type === 'extension') {
                $correct = extension_loaded($name);
                $text = $correct ? $this->msgLoaded : $this->msgNotLoaded;
            } else
            // ini
            if ($type === 'ini') {
                $ini = ini_get($name);
                if ($value === null) {
                    $correct = $ini !== false;
                    $text = $correct ? $ini : $this->msgNotInstalled;

                } else {
                    $correct = $ini === $value;
                    $text = $ini === false ? $this->msgNotInstalled : $ini;
                }
            } else
            // php
            if ($type === 'php') {
                $correct = $this->checkPHP();
                $text = PHP_VERSION;
            } else
            // apache
            if ($type === 'apache') {
                $correct = $this->checkApache();
                $text = $this->getApacheVersion();
            } else {
                $text = '';
                $correct = false;
            }

            if ($correct === false) {
                $checked = false;
            }

            $result[$name] = Html::tag(
                $this->itemTag,
                $text, 
                [
                    'class' => $correct ? $this->itemTagClsCorrect : $this->itemTagClsFailure
                ]
            );
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Preliminary check');
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
            header('Location: ' . $this->installer->makeUrl('choice'));
        }
    }
}