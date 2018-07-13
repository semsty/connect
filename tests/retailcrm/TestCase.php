<?php

namespace tests\retailcrm;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\retailcrm\action\lists\Dictionaries;
use semsty\connect\retailcrm\Profile;
use semsty\connect\retailcrm\query\Connection;
use semsty\connect\retailcrm\Service;

class TestCase extends \tests\TestCase
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
