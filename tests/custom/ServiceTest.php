<?php

namespace connect\crm\tests\custom;

use connect\crm\custom\action\Action;
use connect\crm\custom\Profile;
use connect\crm\custom\Service;

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
