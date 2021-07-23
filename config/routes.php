<?php

use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Request;
use App\Controller\AdsController;
use App\Exception\{ValidationFailedException, ResourceNotFoundException};

Router::setDefaultNamespace('App\Controller');

Router::post('/ads', 'AdsController@create');
Router::post('/ads/{id}', 'AdsController@update')->where(['id' => '[0-9]+']);
Router::get('/ads/relevant', 'AdsController@getRelevant');

Router::error(function(Request $request, \Exception $e) {
    if ($e instanceof ValidationFailedException) {
        Router::response()->json([
            'message' => $e->getMessage(),
            'code' => 400,
            'data' => $e->getErrors()
        ]);
    } elseif ($e instanceof ResourceNotFoundException) {
        Router::response()->json([
            'message' => $e->getMessage(),
            'code' => 404,
            'data' => null
        ]);
        
    }
});