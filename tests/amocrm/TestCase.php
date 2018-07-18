<?php

namespace connect\crm\tests\amocrm;

use connect\crm\amocrm\action\Auth;
use connect\crm\amocrm\Profile;
use connect\crm\amocrm\query\Connection;
use connect\crm\amocrm\Service;
use connect\crm\base\helpers\ArrayHelper;

class TestCase extends \connect\crm\tests\TestCase
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
