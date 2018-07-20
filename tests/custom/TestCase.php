<?php

namespace connect\crm\tests\custom;

use connect\crm\custom\Profile;
use connect\crm\custom\Service;

class TestCase extends \connect\crm\tests\TestCase
{
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $profile_config = [
        'custom_config' => [
            'requestConfig' => [
                'url' => [
                    'http://jsonplaceholder.typicode.com/posts/1'
                ]
            ]
        ]
    ];
}
