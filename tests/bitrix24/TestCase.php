<?php

namespace tests\bitrix24;

use semsty\connect\base\helpers\ArrayHelper;
use semsty\connect\bitrix24\action\Auth;
use semsty\connect\bitrix24\Profile;
use semsty\connect\bitrix24\query\Connection;
use semsty\connect\bitrix24\Service;

class TestCase extends \tests\TestCase
{
    public $_connection_class = Connection::class;
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $profile_config = [
        'config' => [
            'access_token' => '1234567890',
            'expires' => 0,
            'expires_in' => 0,
            'scope' => 'crm',
            'domain' => 'subdomain.bitrix24.ru',
            'server_endpoint' => 'https://oauth.bitrix.info/rest/',
            'status' => 'F',
            'client_endpoint' => 'https://subdomain.bitrix24.ru/rest/',
            'member_id' => '1234567890',
            'user_id' => 666,
            'refresh_token' => '1234567890',
        ]
    ];

    public function getResponses()
    {
        return ArrayHelper::merge(parent::getResponses(), [
            Auth::NAME => [
                'access_token' => '0987654321',
                'expires_in' => 3600,
                'scope' => 'crm',
                'domain' => 'subdomain.bitrix24.ru',
                'server_endpoint' => 'https://oauth.bitrix.info/rest/',
                'status' => 'F',
                'client_endpoint' => 'https://subdomain.bitrix24.ru/rest/',
                'member_id' => '1234567890',
                'user_id' => 666,
                'refresh_token' => '0987654321',
            ]
        ]);
    }
}
