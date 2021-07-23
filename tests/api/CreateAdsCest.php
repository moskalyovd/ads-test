<?php

class CreateAdsCest
{
    public function _before(ApiTester $I)
    {
    }

    public function successfullCest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/ads', [
            'text' => 'davert', 
            'price' => 10000,
            'limit' => 10,
            'banner' => 'http://test.com/banner.jpg',
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['code' => 200]);
        $I->seeResponseMatchesJsonType([
            'message' => 'string',
            'code' => 'integer',
            'data' => [
                'id' => 'integer',
                'text' => 'string',
                'banner' => 'string:url',
            ]
        ]);
    }

    public function validationCreateAdsCest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/ads', [
            'text' => '', 
            'price' => '',
            'limit' => '',
            'banner' => '',
        ]);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseContainsJson(['code' => 400]);
        $I->seeResponseMatchesJsonType([
            'message' => 'string',
            'code' => 'integer',
            'data' => [
                'string'
            ]
        ]);
    }
}
