<?php
/**
 * Таблицы используемые картой SQL запросов (раздел "insert").
 * 
 * Применяются в качестве ключей при наполнении таблиц (см. queries.php).
 * 
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

 /** @var string $step Текущий шаг */
$step = $installer->getStepName();
/** подключаемые таблицы, например:
$data = array_merge_recursive(
    require('tables/table.php'),
    require('tables/table-1.php'),
);
*/
$data = [];

// если шаг "Сборка" и применить демонстрационные данные
if ($applyDemo && $step === 'assembly') {
    $data = array_merge_recursive(
        $data,
        // Демонстрационные данные
        require('tables/demo.php')
    );
}
return $data;
