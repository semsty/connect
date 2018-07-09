<?php

namespace tests\amocrm;

use semsty\connect\amocrm\actions\Auth;
use semsty\connect\amocrm\Profile;
use semsty\connect\amocrm\query\Connection;
use semsty\connect\amocrm\Service;
use semsty\connect\base\helpers\ArrayHelper;

class TestCase extends \tests\TestCase
{
    public $_connection_class = Connection::class;
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $profile_config = [
        'subdomain' => 'subdomain',
        'apiKey' => 'imanicelittletoken',
        'login' => 'login@subdomain.com'
    ];

    public function getResponse()
    {
        return ArrayHelper::merge(parent::getResponses(), [
            Auth::NAME => [
                'success' => true
            ]
        ]);
    }
}
