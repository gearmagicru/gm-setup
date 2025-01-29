<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

use Gm\Db\QueriesMap;
use Gm\Mvc\Application;
use Gm\Installer\Installer;
use Gm\Installer\InstallerSteps;
use Gm\Exception\BaseException;

/**
 * Установщик.
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup
 * @since 1.0
 */
class Setup extends Installer
{
    /**
     * {@inheritdoc}
     */
    public string $route = 'setup';

    /**
     * {@inheritdoc}
     */
    public string $lockName = '.setup';

    /**
     * {@inheritdoc}
     */
    public string $localPath = '/gm/gm.setup';

    /**
     * {@inheritdoc}
     */
    protected array|InstallerSteps $steps = [
        'common' => [
            'welcome' => '\Gm\Setup\CommonChoice\StepWelcome',
            'check'   => '\Gm\Setup\CommonChoice\StepCheck',
            'choice'  => [
                'class' => '\Gm\Setup\CommonChoice\StepChoice',
                'steps' => [
                    'new' => [
                        'license'      => '\Gm\Setup\NewChoice\StepLicense',
                        'registration' => '\Gm\Setup\NewChoice\StepRegistration',
                        'db'           => '\Gm\Setup\NewChoice\StepDb',
                        'dbcharset'    => '\Gm\Setup\NewChoice\StepDbCharset',
                        'checkout'     => '\Gm\Setup\NewChoice\StepCheckout',
                        'assembly'     => '\Gm\Setup\NewChoice\StepAssembly',
                        'info'         => '\Gm\Setup\NewChoice\StepInfo',
                        'account'      => '\Gm\Setup\NewChoice\StepAccount',
                        'finish'       => '\Gm\Setup\NewChoice\StepFinish'
                    ],
                    'dbaccount' => [
                        'db'        => '\Gm\Setup\DbAccountChoice\StepDb',
                        'dbcharset' => '\Gm\Setup\DbAccountChoice\StepDbCharset',
                        'checkout'  => '\Gm\Setup\DbAccountChoice\StepCheckout',
                        'finish'    => '\Gm\Setup\DbAccountChoice\StepFinish'
                    ],
                    'repair' => [
                        'update' => '\Gm\Setup\Repair\StepAssembly',
                        'finish' => '\Gm\Setup\Repair\StepFinish'
                    ]
                ]
            ]
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function createApp(bool $withParams = false): Application
    {
        // создаст приложение уже с сформированным файлов конфигурации '.application.php'
        if (!$withParams) {
            return parent::createApp();
        }

        require BASE_PATH . DS . 'app/Application.php';

        /** @var string $pathConfig Базовый путь к файлам конфигурации **/
        $pathConfig = BASE_PATH . CONFIG_PATH;

        return App\Application::initWith([
                'language' => 'ru',
                'timeZone' => 'UTC',
                'dataTimeZone' => 'UTC',
                'encoding' => [
                    'internal' => 'utf-8',
                    'external' => 'utf-8'
                ],
                // Конфигурация Панели управления
                BACKEND => [
                    'route'  => '',
                    'router' => [
                        'factory' => ['filename' => $pathConfig . DS . BACKEND . '/.router.php']
                    ],
                    'services' => [
                        'factory' => ['filename' => $pathConfig . DS . BACKEND . '/.services.php']
                    ]
                ],
                // Конфигурация веб-сайта
                FRONTEND => [
                    'router' => [
                        'factory' => ['filename' => $pathConfig . DS . FRONTEND . '/.router.php']
                    ],
                    'services' => [
                        'factory' => ['filename' => $pathConfig . DS . FRONTEND . '/.services.php']
                    ]
                ],
                // Конфигурация унифицированного конфигуратора
                'unified' => [
                    'factory' => ['filename' => $pathConfig . '/.unified.php']
                ],
                'services' => [
                    'factory' => [
                        'filename' => $pathConfig . '/.services.php',
                        'defaults' => [
                            'request'   => ['class' => '\Gm\Http\Request'],
                            'encrypter' => ['class'  => '\Gm\Encryption\Encrypter']
                        ]
                    ]
                ],
                'params' => []
            ]);
    }

    /**
     * Возвращает все доступные часовые пояса.
     * 
     * Все часовые пояса со смещение по времени относительно часового пояса UTC.
     * 
     * @param null|string $locale Имя языка, слаг или локаль, например: 'ru' ('ru_RU', 'ru-RU'), 
     *     'en' ('en_GB', 'en-GB') (по умолчанию `null`).
     * 
     * @return array
     */
    public function getTimeZones(string $locale = null): array
    {
        if ($locale) {
            if (mb_strpos($locale, '-') !== false) {
                $chunks = explode('-', $locale);
                $locale = $chunks[0];
            } else
            if (mb_strpos($locale, '_') !== false) {
                $chunks = explode('_', $locale);
                $locale = $chunks[0];
            }
        }

        // если подключено расширение INTL
        $intlIsLoaded = extension_loaded('intl');
        // сохраняем часовой пояси клиента и расчёт делаем в UTC
        $defaultTimezone = date_default_timezone_get();
        date_default_timezone_set('UTC');

        $dateTimeUTC = new DateTime('now');
        $result = [];
        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $dateTimeZone = new DateTimeZone($timezone);
            if ($intlIsLoaded) {
                $intlTimeZone = \IntlTimeZone::createTimeZone($timezone);
                if ($intlTimeZone->getID() === 'Etc/Unknown' or $timezone === 'UTC')
                    $name = $timezone;
                else
                    $name = $intlTimeZone->getDisplayName(false, 3, $locale) ?: $timezone;
                if (mb_strlen($name) <= 3) {
                    $name = $timezone;
                }
            } else
                $name = $timezone;
            // смещение
            $offset = $dateTimeZone->getOffset($dateTimeUTC);
            if ($offset)
                $offsetTime = date('H:i', abs($offset));
            else
                $offsetTime = '00:00';
           $result[] = ['timezone' => $timezone, 'name' => $name, 'offsetTime' => (($offset < 0) ? '-' : '+') . $offsetTime, 'offset' => $offset];
        }
        // восстанавливаем часовой пояс клиенту
        date_default_timezone_set($defaultTimezone);

        // сортировка смещению в часовом поясе
        array_multisort(
            array_column($result, 'offset'), SORT_ASC, 
            $result
        );
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueriesMap(array $config = []): QueriesMap
    {
        if (!isset($this->queriesMap)) {
            $config['filename'] = $this->getQueriesPath() . DS . 'queries.php';
            $this->queriesMap = new QueriesMap($config);
        }
        return $this->queriesMap;
    }

    /**
     * {@inheritdoc}
     */
    protected function initLoader(): void
    {
        parent::initLoader();

        Gm::$loader->addPsr4('Gm\\Setup\\', $this->getPath() . DS . 'src');
    }

    /**
     * Последнее исключение установщика.
     * 
     * Здесь будет поймано исключение если оно ранее нигде не было поймано.
     * 
     * @param Exception $exception Исключение.
     * 
     * @return void
     * 
     * @throws Exception Исключение если не указан обработчик ошибок {@see Setup::$errorHandler}.
     */
    public function endException($exception): void
    {
        if ($this->errorHandler !== null) {
            $this->errorHandler->uncatchableException($exception);
        } else
            throw $exception;
    }

    /**
     * {@inheritdoc}
     */
    public function run(): void
    {
        $view = $this->getView();

        if ($this->router->isMatch()) {
            // если необходимо зупустить установщик
            if ($this->accessibly()) {
                $steps = $this->getSteps();
                try {
                    $step = $steps->createStep();
                    if ($step) {
                        die($view->render('setup', [
                            'content' => $step->run(),
                            'version' => $this->getAppVersion(),
                            'edition' => $this->getAppEdition(),
                            'config'  => $this->config,
                            'steps'   => $steps,
                            'step'    => $step,
                        ]));
                    }
                } catch (BaseException $e) {
                    $this->endException($e);
                }
            }
        }

        die($view->render('404', [
            'edition' => $this->getAppEdition(),
            'version' => $this->getAppVersion(),
            'config'  => $this->config
        ]));
    }
}