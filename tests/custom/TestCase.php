<?php

namespace tests\custom;

use semsty\connect\custom\Profile;
use semsty\connect\custom\Service;

class TestCase extends \tests\TestCase
{
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $profile_config = [
        'custom_config' => [
            'requestConfig' => [
                'url' => [
                    'https://jsonplaceholder.typicode.com/posts/1'
                ]
            ]
        ]
    ];
}
