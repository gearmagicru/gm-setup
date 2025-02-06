<?php
/**
 * Этот файл является частью установщка веб-приложения GearMagic.
 * 
 * @link https://gearmagic.ru
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

/**
 * Извещаем приложение и его модули, что запущен установщик.
 */
define('IS_INSTALL_MODE', true);

require 'src/Setup.php';

/**
 * Выполнение инициализации и запуска установщика.
 */
$setup = Setup::init();
$setup->run();