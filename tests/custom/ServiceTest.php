<?php

namespace tests\custom;

use semsty\connect\custom\actions\Action;
use semsty\connect\custom\Profile;
use semsty\connect\custom\Service;

class ServiceTest extends TestCase
{
    public function testResponse()
    {
        $profile = new Profile([
            'custom_config' => [
                'requestConfig' => [
                    'url' => [
                        'https://jsonplaceholder.typicode.com/posts/1'
                    ]
                ]
            ]
        ]);
        $service = new Service([
            'profile' => $profile
        ]);
        $action = $service->action(Action::ID);
        $data = $action->run();
        expect($data)->notEmpty();
        expect(is_array($data))->true();
    }
}
