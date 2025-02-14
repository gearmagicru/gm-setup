# GM Setup

Установщик для всех редакций веб-приложения GearMagic. Выполняет пошаговую установку всех компонентов веб-приложения.

[![Latest Stable Version](https://img.shields.io/packagist/v/gearmagicru/gm-setup.svg)](https://packagist.org/packages/gearmagicru/gm-setup)
[![Total Downloads](https://img.shields.io/packagist/dt/gearmagicru/gm-setup.svg)](https://packagist.org/packages/gearmagicru/gm-setup)
[![Author](https://img.shields.io/badge/author-anton.tivonenko@gmail.com-blue.svg)](mailto:anton.tivonenko@gmail)
[![Source Code](https://img.shields.io/badge/source-gearmagicru/gm--setup-blue.svg)](https://github.com/gearmagicru/gm-setup)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/gearmagicru/gm-setup/blob/master/LICENSE)
![Component type: module](https://img.shields.io/badge/framework%20component-installer-green.svg)
![php 8.2+](https://img.shields.io/badge/php-min%208.2-red.svg)

## Установка

В проект каждой редакции веб-приложения GearMagic добавлен установщик со своими настройками. 
Если ваш проект не имеет установщика, вы можете просто выполнить команду ниже:

```
$ composer require gearmagicru/gm-setup
```

или добавить в файл composer.json вашего проекта:
```
"require": {
	"gearmagicru/gm-setup": "*"
}
```

После установки, вам необходимо будет добавить следующие файлы:
- `/queries/tables.php`, таблицы используемые картой SQL запросов;
- `/queries/variables.php`, идентификаторы (переменные) запроса.

Эти файлы присутствуют в репозитории в качестве шаблонов, но не экспортируются.
