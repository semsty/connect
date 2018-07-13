<?php

namespace tests\base;

use semsty\connect\custom\Profile;
use semsty\connect\custom\Service as CustomService;
use Yii;

class ConnectTest extends TestCase
{
    public function testConnect()
    {
        $url = 'https://jsonplaceholder.typicode.com/posts/1';
        expect(Yii::$app->connect)->notEmpty();
        expect(Yii::$app->connect->custom)->isInstanceOf(CustomService::class);
        $svc = Yii::$app->connect->byProfile([
            'service_id' => CustomService::ID,
            'custom_config' => [
                'requestConfig' => [
                    'url' => [
                        $url
                    ]
                ]
            ]
        ], false);
        expect($svc->profile)->isInstanceOf(Profile::class);
    }
}
