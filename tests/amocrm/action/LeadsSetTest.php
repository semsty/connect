<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\LeadsSet as Action;
use connect\crm\amocrm\query\Query;
use connect\crm\amocrm\query\Response;
use connect\crm\tests\amocrm\TestCase;

class LeadsSetTest extends TestCase
{
    public function testRun()
    {
        $action = $this->service->action(Action::ID);
        $action->data = [
            'add' => [
                [
                    'status_id' => 1,
                    123456 => '654321',
                    654321 => '123456'
                ]
            ]
        ];
        expect($action->config)->equals([
            'baseUrl' => 'https://{subdomain}.amocrm.ru/',
            'requestConfig' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer imanicelittletoken'
                ],
                'options' => [
                    'timeout' => 60,
                    'returntransfer' => true,
                    'referer' => null,
                    'useragent' => 'amoCRM-API-client/1.0',
                    'ssl_verifyhost' => false,
                    'ssl_verifypeer' => false
                ],
                'url' => [
                    '0' => 'https://{subdomain}.amocrm.ru/api/{version}/leads',
                    'version' => 'v4',
                    'subdomain' => 'subdomain'
                ],
                'method' => 'POST',
                'data' => [
                    [
                        'status_id' => 1,
                        'custom_fields_values' => [
                            [
                                'field_id' => 123456,
                                'values' => [
                                    ['value' => '654321']
                                ]
                            ],
                            [
                                'field_id' => 654321,
                                'values' => [
                                    ['value' => '123456']
                                ]
                            ]
                        ]
                    ]
                ],
                'class' => Query::class,
                'format' => 'json'
            ],
            'responseConfig' => [
                'class' => Response::class
            ],
            'transport' => 'yii\\httpclient\\CurlTransport'
        ]);
    }
}