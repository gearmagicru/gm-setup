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
use Gm\Db\Adapter\Exception\ConnectException;

/**
 * Шаг установки "Подключение к базе данных".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepDb extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'db';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/db';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:registration');
    }

    /**
     * {@inheritdoc}
     */
    protected function initAction(): void
    {
        if (!$this->hasAction()) {
            // если было проверено соединение сбросить его
            $this->state->dbConnected = false;
        }

        parent::initAction();
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        // база данных уже создана на сервере
        $this->state->dbCreated = isset($_POST['dbCreated']);

        // префикс таблиц 
        $tablePrefix = $_POST['dbTablePrefix'] ?? '';
        if (empty($tablePrefix)) {
            $this->state->dbTablePrefix = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Table prefix')]));
        } else
            $this->state->dbTablePrefix = $tablePrefix;

        // пароль пользователя базы данных 
        $password = $_POST['dbPassword'] ?? '';
        if (empty($password)) {
            $this->state->dbPassword = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database user password')]));
        } else
            $this->state->dbPassword = $password;

        // имя пользователя базы данных
        $username = $_POST['dbUsername'] ?? '';
        if (empty($username)) {
            $this->state->dbUsername = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database username')]));
        } else
            $this->state->dbUsername = $username;

        // имя базы данных
        $schema = $_POST['dbSchema'] ?? '';
        if (empty($schema)) {
            $this->state->dbSchema = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database name')]));
        } else
            $this->state->dbSchema = $schema;

        // порт сервера
        $port = $_POST['dbPort'] ?? '';
        if (empty($port)) {
            $this->state->dbPort = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Server port')]));
        } else
            $this->state->dbPort = $port;

        // сервер базы данных
        $host = $_POST['dbHost'] ?? '';
        if (empty($host)) {
            $this->state->dbHost = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database server')]));
        } else
            $this->state->dbHost = $host;

        // драйвер база данных
        $driver = $_POST['dbDriver'] ?? '';
        if (empty($driver)) {
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database')]));
        } else {
            if (!in_array($driver, ['MySqli'])) {
                $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Database')]));
            }
            $this->state->dbDriver = $driver;
        }
        $this->state->dbEngine = 'InnoDB';
        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Database connection');
    }

    /**
     * Выполняет проверку соединения с базой данных.
     * 
     * @return bool
     */
    protected function runTest(): bool
    {
        // параметры подключения к серверу
        $params = [
            'host'     => $this->state->dbHost,
            'password' => $this->state->dbPassword,
            'username' => $this->state->dbUsername,
            'port'     => $this->state->dbPort
        ];

        // если выбран флаг "база данных уже создана на сервере"
        if ($this->state->dbCreated) {
            $params['schema'] = $this->state->dbSchema;
        }

        // драйвер адаптера базы данных
        $className = '\Gm\Db\Adapter\Driver\\' . $this->state->dbDriver . '\Connection';
        if (!class_exists($className)) {
            $this->addError(
                $this->t('Unable to find connection driver "%s"', [$this->state->dbDriver]),
                $this->t('Database driver error')
            );
            return false;
        }

        /** @var \Gm\Db\Adapter\Driver\AbstractConnection $connection */
        $connection = new $className($params);

        try {
            $connection->connect();
        } catch (ConnectException $exception) {
            $this->addError($exception->getMessage(), $this->t('Error connecting to database server'));
        }
        return !isset($exception);
    }

    /**
     * Выполняет действие "Test" (проверка соединения).
     * 
     * @return void
     */
    public function testAction(): void
    {
        if ($this->validate()) {
            $this->state->dbConnected = $this->runTest();
            if ($this->state->dbConnected) {
                // отметить завершение шага
                $this->complete();
            }
        } else
            $this->state->dbConnected = false;
        $this->updateState();
    }
}