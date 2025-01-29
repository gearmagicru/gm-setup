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
use Gm\Panel\User\UserProfile;
use Gm\Panel\User\UserIdentity;
use Gm\Installer\AppConfigFile;
use Gm\Db\Adapter\Exception\ConnectException;
use Gm\Db\Adapter\Exception\CommandException;
use Gm\Db\Adapter\Driver\Exception\DriverException;

/**
 * Шаг установки "Создание аккаунта пользователя".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepAccount extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'account';

    /**
     * {@inheritdoc}
     */
    public string  $viewName = 'new/account';

    /**
     * @see StepAccount::getUserIdentity()
     * 
     * @var UserIdentity
     */
    protected UserIdentity $userIdentity;

    /**
     * @see StepAccount::getUserProfile()
     * 
     * @var UserProfile
     */
    protected UserProfile $userProfile;

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:info');
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        // часовой пояс по умолчанию (с предыдущего шага)
        if (empty($this->state->timeZone)) {
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Default timezone')]));
        }

        // часовой пояс сервера (с предыдущего шага)
        if (empty($this->state->dataTimeZone)) {
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Server timezone')]));
        }

        // обращение
        $callName = $_POST['acCallName'] ?? '';
        if (empty($callName)) {
            $this->state->acCallName = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Call name')]));
        } else
            $this->state->acCallName = $callName;
        if (!self::strInRange($callName, 0, 100)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Call name'), 100]));
        }

        // имя
        $firstName = $_POST['acFirstName'] ?? '';
        if (empty($firstName)) {
            $this->state->acFirstName = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('First name')]));
        } else
            $this->state->acFirstName = $firstName;
        if (!self::strInRange($firstName, 0, 100)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('First name'), 100]));
        }

        // фамиля
        $this->state->acSecondName = $_POST['acSecondName'] ?? '';
        if ($this->state->acSecondName) {
            if (!self::strInRange($this->state->acSecondName, 0, 100)) {
                $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Second name'), 100]));
            }
        }
        // отчество
        $this->state->acPatronymicName = $_POST['acPatronymicName'] ?? '';
        if ($this->state->acPatronymicName) {
            if (!self::strInRange($this->state->acPatronymicName, 0, 100)) {
                $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Patronymic name'), 100]));
            }
        }

        // маршрут
        $route = $_POST['acRoute'] ?? '';
        if (empty($route)) {
            $this->state->acRoute = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Route to Control panel')]));
        } else
            $this->state->acRoute = $route;
        if (!self::strInRange($route, 0, 255)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Route to Control panel'), 255]));
        }

        // e-mail
        $email = $_POST['acEmail'] ?? '';
        if (empty($email)) {
            $this->state->acEmail = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', ['E-mail']));
        } else
            $this->state->acEmail = $email;
        if (!self::strInRange($email, 0, 100)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('E-mail'), 100]));
        }

        // имя пользователя
        $username = $_POST['acUsername'] ?? '';
        if (empty($username)) {
            $this->state->acUsername = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Username')]));
        } else
            $this->state->acUsername = $username;
        if (!self::strInRange($username, 3, 50)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s but less than %s characters', [$this->t('Username'), 50, 3]));
        }

        // пароль пользователя
        $password = $_POST['acPassword'] ?? '';
        if (empty($password)) {
            $this->state->acPassword = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('User password')]));
        } else
            $this->state->acPassword = $password;
        if (!self::strInRange($password, 7, 40)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s but less than %s characters', [$this->t('User password'), 40, 7]));
        }

        // подтверждение пароля
        $passwordCnf = $_POST['acPasswordCnf'] ?? '';
        if (empty($passwordCnf)) {
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Password confirmation')]));
        }
        if ($password !== $passwordCnf) {
            $this->addWarning($this->t('Password and Confirm password do not match'));
        }
        return $this->noMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle(): string
    {
        return $this->t('Web application files checkout');
    }

    /**
     * Возвращает аккаунт пользователя.
     * 
     * @see StepAccount::$userIdentity
     * 
     * @return UserIdentity
     */
    protected function getUserIdentity(): UserIdentity
    {
        if (!isset($this->userIdentity)) {
            $this->userIdentity = new UserIdentity();
        }
        return $this->userIdentity;
    }

    /**
     * Возвращает профиль пользователя.
     * 
     * @see StepAccount::$userProfile
     * 
     * @return UserProfile
     */
    protected function getUserProfile(): UserProfile
    {
        if (!isset($this->userProfile)) {
            $this->userProfile = new UserProfile($this->getUserIdentity());
        }
        return $this->userProfile;
    }

    /**
     * Создаёт аккаунт пользователя.
     * 
     * @return bool
     */
    protected function createUserAccount(): bool
    {
        /** @var \Gm\Mvc\Application $app */
        $app = $this->installer->getApp();

        try {
            /** @var UserIdentity $user */
            $user = $this->getUserIdentity();

            /** @var  UserIdentity|null $found Исли аккаунт ранее добавлен */
            if ($found = $user->findIdentity(1)) {
                $found->delete();
            }

            $user->id = 1;
            $user->username = $this->state->acUsername;
            $user->password = $app->encrypter->encodePassword($this->state->acPassword);
            $user->lock = 1;
            $user->save();
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
     * Создаёт профиль пользователя.
     * 
     * @return bool
     */
    protected function createUserProfile(): bool
    {
        try {
            $profile = $this->getUserProfile();

            /** @var null|UserProfile $found Исли профиль ранее добавлен */
            if ($found = $profile->find()) {
                $found->delete();
            }

            $profile->id = 1;
            $profile->userId = 1;
            $profile->gender = 1;
            // обращение
            if ($this->state->acCallName)
                $profile->callName = $this->state->acCallName;
            else
                $profile->callName = ucfirst($this->state->acUsername);
            // имя
            if ($this->state->acFirstName)
                $profile->firstName = $this->state->acFirstName;
            else
                $profile->firstName = ucfirst($this->state->acUsername);
            // фамилия
            if ($this->state->acSecondName) {
                $profile->secondName = $this->state->acSecondName;
            }
            // отчество
            if ($this->state->acPatronymicName) {
                $profile->patronymicName = $this->state->acPatronymicName;
            }
            // email
            if ($this->state->acEmail) {
                $profile->email = $this->state->acEmail;
            }
            // часовой пояс
            if ($this->state->timeZone) {
                $profile->timeZone = $this->state->timeZone;
            }
            $profile->save();
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
     * Создаёт роли пользователей.
     * 
     * @return bool
     */
    protected function createUserRole(): bool
    {
        try {
            /** @var \Gm\Mvc\Application $app */
            $app = $this->installer->getApp();
            /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
            $command = $app->db->createCommand();

            // добавление роли супер администратора (через QueriesMap)
            /*
            $command
                ->truncateTable('{{role}}')
                ->execute()
                ->insert('{{role}}', [
                    'id'          => 1,
                    'name'        => $this->t('Super administrator'),
                    'shortname'   => 'root',
                    'description' => $this->t('Super admins'),
                    '_lock'       => 1
                ])
                ->execute();
            */

            // добавление роли пользователю
            $command
                ->truncateTable('{{user_roles}}')
                ->execute()
                ->insert('{{user_roles}}', ['user_id' => 1, 'role_id' => 1])
                ->execute();
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
     * Создаёт права доступа к модулям и их расширениям.
     * 
     * @return bool
     */
    protected function createPermissions(): bool
    {
        try {
            /** @var \Gm\Mvc\Application $app */
            $app = $this->installer->getApp();
            /** @var \Gm\Db\Adapter\Driver\AbstractCommand $command */
            $command = $app->db->createCommand();

            // добавление прав доступа к модулям
            $command
                ->delete('{{module_permissions}}', ['role_id' => 1])
                ->execute();
            $rows = $this->state->modules['permissions'] ?? [];
            foreach ($rows as $row) {
                $command
                    ->insert('{{module_permissions}}', [
                        'module_id'  => $row['id'],
                        'role_id'    => 1,
                        'permissions' => $row['permissions']
                    ])
                    ->execute();
            }

            // добавление прав доступа к расширениям модулей
            $command
                ->delete('{{extension_permissions}}', ['role_id' => 1])
                ->execute();
            $rows = $this->state->extensions['permissions'] ?? [];
            foreach ($rows as $row) {
                $command
                    ->insert('{{extension_permissions}}', [
                        'extension_id' => $row['id'],
                        'role_id'      => 1,
                        'permissions'  => $row['permissions']
                    ])
                    ->execute();
            }
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
     * Создаёт файлы конфигурации веб-приложения.
     * 
     * @return bool
     */
    protected function createConfigFiles(): bool
    {
        $config = new AppConfigFile(CONFIG_PATH . DS . '.application.php');
        $created = $config->create([
            'language'            => $this->state->language,
            'backendRoute'        => $this->state->acRoute,
            'cookieValidationKey' => md5(time() . uniqid('', true)),
            'markupValidationKey' => md5(time() . uniqid('', true)),
            'encrypterKey'        => mb_substr(md5(uniqid('', true) . time()), 1, 16),
            'timeZone'            => $this->state->timeZone ?? 'UTC',
            'dataTimeZone'        => $this->state->dataTimeZone ?? 'UTC'
        ]);
        if (!$created) {
            $this->addError(
                $this->t('Cannot write to app configuration file "%s"', [$config->getFilename()]),
                $this->t('File write error')
            );
            return false;
        }
        return true;
    }

    /**
     * Выполняет действие "Create" (создаёт аккаунт пользователя).
     * 
     * @return void
     */
    protected function createAction(): void
    {
        if ($this->validate()) {
            // создание файла конфигурации веб-приложения
            if ($this->createConfigFiles()) {
                // создание аккаунта пользователю
                if ($this->createUserAccount()) {
                    // создание профиля пользователю
                    if ($this->createUserProfile()) {
                        // создание роли пользователя
                        if ($this->createUserRole()) {
                            // создание прав доступа
                            if ($this->createPermissions()) {
                                // отметить завершение шага
                                $this->complete();
                                // обновить изменения сделанные шагом
                                if ($this->updateState()) {
                                    header('Location: ' . $this->installer->makeUrl('new:finish'));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}