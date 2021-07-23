<?php

require_once __DIR__ . '/vendor/autoload.php';

use Pimple\Container;
use Pimple\Psr11\Container as PsrContainer;
use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;
use App\Router\PimpleClassLoader;

require_once __DIR__ . '/config/routes.php';
require_once __DIR__ . '/config/db.php';

// тут мы заполняем di контейнер и решаем зависимости
$container = require_once __DIR__ . '/config/di.php';

// оборачиваем контейнер psr-11 контейнером
$psrContainer = new PsrContainer($container);

// используем кастомный класс лоадер, чтобы мы могли использовать di в контроллерах
SimpleRouter::setCustomClassLoader(new PimpleClassLoader($psrContainer));

// начинаем маршрутизацию запросов
SimpleRouter::start();