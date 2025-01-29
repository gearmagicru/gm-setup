<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\DbAccountChoice;

use Gm\Setup\SetupStep;
use Gm\Db\Adapter\Adapter;
use Gm\Db\Adapter\Exception\ConnectException;
use Gm\Db\Adapter\Exception\CommandException;
use Gm\Db\Adapter\Driver\Exception\DriverException;

/**
 * Шаг установки "Подключение к базе данных".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\DbAccountChoice
 * @since 1.0
 */
class StepDbCharset extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'dbcharset';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'dbaccount/dbcharset';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('dbaccount:db');
    }

    /**
     * @return void
     */
    protected function initParams(): void
    {
        parent::initParams();

        // кодировка подключения
        $this->params['dbCharsets']   = [];
        // сопоставление 
        $this->params['dbCollations'] = [];

        // если в предыдущем шаге была выполнена проверка подключения
        if ($this->state->dbConnected ?? false) {
            try {
                $adapter = $this->getAdapter();
                $adapter->connect();

                $this->params['dbCharsets'] = $adapter
                    ->createCommand()
                        ->getCharsets();
                $this->params['dbCollations'] = $adapter
                    ->createCommand()
                        ->getCollations();
            } catch (ConnectException $exception) {
                $this->addError($exception->getMessage(), $this->t('Error connecting to database server'));
            } catch (DriverException $exception) {
                $this->addError($exception->getMessage(), $this->t('Database driver error'));
            } catch (CommandException $exception) {
                $this->addError($exception->getMessage(), $this->t('SQL query execution error'));
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initAction(): void
    {
        if (!$this->hasAction()) {
            // сбрасываем параметры
            $this->state->dbCharset = '';
            $this->state->dbCollate = '';
            $this->state->dbCharsetUtf8 = false;
        }

        parent::initAction();
    }

    /**
     * Возвращает адаптер подключения к базе данных.
     * 
     * @param string $charset Кодировка подключения (по умолчанию `null`).
     * @param string $collate Сопоставление (по умолчанию `null`).
     *
     * @return Adapter
     */
    protected function getAdapter(string $charset = null, string $collate = null): Adapter
    {
        $params = [
            'host'     => $this->state->dbHost,
            'password' => $this->state->dbPassword,
            'username' => $this->state->dbUsername,
            'port'     => $this->state->dbPort,
            'driver'   => $this->state->dbDriver,
            'schema'   => $this->state->dbSchema
        ];
        if ($charset) {
            $params['charset'] = $charset;
        }

        $connections = new \Gm\Config\Config();
        $connections->setAll(['default' => $params]);

       return new Adapter([
            'connections'     => $connections,
            'connectionName'  => 'default',
            'enableProfiling' => false,
            'autoConnect'     => false
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        // использовать по умолчанию кодировку UTF8
        $this->state->dbCharsetUtf8 = isset($_POST['dbCharsetUtf8']);

        if (!$this->state->dbCharsetUtf8) {
            // кодировка подключения
            $charset = $_POST['dbCharset'] ?? '';
            if (empty($charset)) {
                $this->state->dbCharset = '';
                $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Charset')]));
            } else
                $this->state->dbCharset = $charset;

            // сопоставление
            $collate = $_POST['dbCollate'] ?? '';
            if (empty($collate)) {
                $this->state->dbCollate = '';
                $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Collate')]));
            } else
                $this->state->dbCollate = $collate;
        } else {
            $this->state->dbCharset = 'utf8';
            $this->state->dbCollate = 'utf8_general_ci';
        }
        return true;
    }

    /**
     * Выполняет проверку соединения с базой данных.
     * 
     * @return bool
     */
    protected function runTest(): bool
    {
        try {
            $adapter = $this->getAdapter($this->state->dbCharset);
            $adapter->connect();
        } catch (ConnectException $exception) {
            $this->addError($exception->getMessage(), $this->t('Error connecting to database server'));
        } catch (DriverException $exception) {
            $this->addError($exception->getMessage(), $this->t('Database driver error'));
        } catch (CommandException $exception) {
            $this->addError($exception->getMessage(), $this->t('SQL query execution error'));
        }
        return !isset($exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Database connection');
    }

    /**
     * Выполняет действие "Test" (проверка соединения).
     * 
     * @return void
     */
    public function testAction()
    {
        if ($this->validate()) {
            $this->state->dbConnectedCharset = $this->runTest();
            if ($this->state->dbConnectedCharset) {
                // отметить завершение шага
                $this->complete();
            }
        } else
            $this->state->dbConnectedCharset = false;
        $this->updateState();
    }
}