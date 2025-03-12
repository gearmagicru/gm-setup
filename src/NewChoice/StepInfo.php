<?php
/**
 * Этот файл является частью установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

namespace Gm\Setup\NewChoice;

use Gm\Helper\Url;
use Gm\Config\Config;
use Gm\Setup\SetupStep;

/**
 * Шаг установки "Информация".
 * 
 * @author Anton Tivonenko <anton.tivonenko@gmail.com>
 * @package Gm\Setup\NewChoice
 * @since 1.0
 */
class StepInfo extends SetupStep
{
    /**
     * {@inheritdoc}
     */
    public string $name = 'info';

    /**
     * {@inheritdoc}
     */
    public string $viewName = 'new/info';

    /**
     * {@inheritdoc}
     */
    public function beforeInit(): bool
    {
        return $this->installer->isCompleted('new:assembly');
    }

    /**
     * @return void
     */
    protected function initParams(): void
    {
        parent::initParams();

        $this->params['timezones'] = $this->installer->getTimeZones($this->state->language ?? null);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): bool
    {
        // часовой пояс по умолчанию
        $timeZone = $_POST['timeZone'] ?? '';
        if (empty($timeZone)) {
            $this->state->timeZone = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Default timezone')]));
        } else
            $this->state->timeZone = $timeZone;

        // часовой пояс сервера
        $dataTimeZone = $_POST['dataTimeZone'] ?? '';
        if (empty($dataTimeZone)) {
            $this->state->dataTimeZone = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Server timezone')]));
        } else
            $this->state->dataTimeZone = $dataTimeZone;

        // название
        $pageTitle = $_POST['pageTitle'] ?? '';
        if (empty($pageTitle)) {
            $this->state->pageTitle = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Name')]));
        } else
            $this->state->pageTitle = $pageTitle;
        if (!self::strInRange($pageTitle, 0, 255)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Name'), 255]));
        }

        // описание
        $pageDesc = $_POST['pageDesc'] ?? '';
        if (empty($pageDesc)) {
            $this->state->pageDesc = '';
            $this->addWarning($this->t('You need to fill in the field "%s"', [$this->t('Description')]));
        } else
            $this->state->pageDesc = $pageDesc;
        if (!self::strInRange($pageDesc, 0, 255)) {
            $this->addWarning($this->t('The field "%s" must have no more than %s characters', [$this->t('Description'), 255]));
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
     * Создаёт унифицированный файл конфигурации веб-приложения.
     * 
     * @return bool
     */
    protected function createConfigFiles(): bool
    {
        /** @var Config $unified */
        $unified = new Config(BASE_PATH . CONFIG_PATH . DS . '.unified.php', true);
        /** @var array $mail Параметры службы \Gm\Site\Page */
        $page = [
            'titlePattern' => '%s - ' . $this->state->pageTitle,
            'title'        => $this->state->pageTitle, 
            'description'  => $this->state->pageDesc,
            'keywords'     => empty($this->state->pageKeywords) ? $this->state->pageDesc : $this->state->pageKeywords,
            'robots'       => 'index, follow'
        ];
    
        /** @var array $languages */
        $languages = (new Config(BASE_PATH . CONFIG_PATH . DS . '.language.php'))->getAll();
        foreach ($languages as $locale => $params) {
            $page['meta'][$params['tag']] = [
                'titlePattern' => '%s - ' . $this->state->pageTitle,
                'title'        => $this->state->pageTitle,
                'author'       => '',
                'keywords'     => $this->state->pageDesc,
                'description'  => $this->state->pageDesc,
                'image'        => '',
                'robots'       => 'index, follow'
            ];
        }

        /** @var array $mail Параметры службы \Gm\Mail\Mail */
        $mail = [
            'noreplyAddress' => 'no-reply@' . Url::hostInfo(),
            'fromAddress'    => 'support@' . Url::hostInfo()
        ];

        $unified->mail = $mail;
        $unified->page = $page;
        if (!$unified->save()) {
            $this->addError(
                $this->t('Cannot write to app configuration file "%s"', [$unified->getFilename()]),
                $this->t('File write error')
            );
        }
        return true;
    }

    /**
     * Выполняет действие "info" (создаёт файл конфигурации).
     * 
     * @return void
     */
    protected function infoAction(): void
    {
        if ($this->validate()) {
            // создание файла конфигурации веб-приложения
            if ($this->createConfigFiles()) {
                // отметить завершение шага
                $this->complete();
                // обновить изменения сделанные шагом
                if ($this->updateState()) {
                    header('Location: ' . $this->installer->makeUrl('new:account'));
                }
            }
        }
    }
}
