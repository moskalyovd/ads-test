<?php

use Pecee\SimpleRouter\SimpleRouter;
use Pimple\Container;
use Pecee\Http\Request;
use App\Controller\AdsController;
use App\Repository\{DoctrineAdsRepository, AdsRepositoryInterface, DoctrineAdsViewRepository, AdsViewRepositoryInterface};
use Rakit\Validation\Validator;
use App\Service\AdsService;

$container = new Container();

$container[AdsRepositoryInterface::class] = function (Container $c) use ($conn) {
    return new DoctrineAdsRepository($conn);
};

$container[AdsViewRepositoryInterface::class] = function (Container $c) use ($conn) {
    return new DoctrineAdsViewRepository($conn);
};

$container[AdsService::class] = function (Container $c) {
    return new AdsService($c[AdsRepositoryInterface::class], $c[AdsViewRepositoryInterface::class]);
};

$container[Validator::class] = function (Container $c) {
    return new Validator();
};

$container[AdsController::class] = function (Container $c) {
    return new AdsController($c[AdsService::class], $c[Validator::class]);
};

$container[Request::class] = function (Container $c) {
    return SimpleRouter::request();
};

return $container;