<?php
/**
 * Файл конфигурации установщика веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

/** @var \Gm\Installer\Installer $installer Установщик  */
$installer = $this->getParam('installer');
/** @var bool $applyDemo Применять демонстрационные данные  */
$applyDemo =  $this->getParam('applyDemo');

/** @var array $variables Идентфикаторы */
$variables = require('variables.php');
foreach ($variables as $variable => $value) {
    $$variable = $value;
}

return [
    'variables' => $variables,
    'insert'    => require('tables.php'),
    'run'       => ['install' => ['insert']]
];