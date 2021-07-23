<?php

namespace App\Controller;

use Pecee\SimpleRouter\SimpleRouter as Router;

abstract class AbstractController
{
    /**
     * Метод останавливает дальнейшее выполнение кода и возвращает json ответ
     *
     * @param array $data
     *
     * @return void
     */
    public function returnJsonResponse(array $data): void
    {
        Router::response()->json($data);
    }
}