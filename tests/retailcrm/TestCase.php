<?php

namespace connect\crm\tests\retailcrm;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\retailcrm\action\lists\Dictionaries;
use connect\crm\retailcrm\Profile;
use connect\crm\retailcrm\query\Connection;
use connect\crm\retailcrm\Service;

class TestCase extends \connect\crm\tests\TestCase
{
    public $_connection_class = Connection::class;
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $profile_config = [
        'subdomain' => 'subdomain',
        'apiKey' => 'imanicelittletoken'
    ];

    public function getResponse()
    {
        return ArrayHelper::merge(parent::getResponses(), [
            Dictionaries::NAME => [
                'success' => true,
                'customDictionaries' => [
                    'dict1' => ['ae']
                ]
            ]
        ]);
    }
}
