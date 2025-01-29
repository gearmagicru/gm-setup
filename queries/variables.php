<?php
/**
 * Идентификаторы (переменные) запроса.
 * 
 * Применяются в качестве ключей при наполнении таблиц (см. queries.php).
 * 
 * @copyright Copyright (c) 2015 Веб-студия GearMagic
 * @license https://gearmagic.ru/license/
 */

 /** подключаемые идентификаторы запроса, например:
$vars = array_merge_recursive(
    require('variables/sample.php'),
    require('variables/sample-1.php')
);
*/
$vars = [];

// смещение всех идентификаторов
foreach ($vars as $name => &$items) {
    array_unshift($items, '');
    unset($items[0]);
    $items = array_flip($items);
}
return $vars;