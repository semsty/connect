<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\NotesSet as Action;
use connect\crm\amocrm\query\Query;
use connect\crm\amocrm\query\Response;
use connect\crm\tests\amocrm\TestCase;

class NotesSetTest extends TestCase
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
                    'Content-Type' => 'application/json'
                ],
                'options' => [
                    'timeout' => 60,
                    'returntransfer' => true,
                    'referer' => null,
                    'cookiejar' => getenv('CONNECT_CORE_DIR') . '/tests/app/runtime/log/amocrm/imanicelittletoken/cookie.txt',
                    'cookiefile' => getenv('CONNECT_CORE_DIR') . '/tests/app/runtime/log/amocrm/imanicelittletoken/cookie.txt',
                    'useragent' => 'amoCRM-API-client/1.0',
                    'ssl_verifyhost' => false,
                    'ssl_verifypeer' => false
                ],
                'url' => [
                    '0' => 'https://{subdomain}.amocrm.ru/api/{version}/notes',
                    'version' => 'v2',
                    'subdomain' => 'subdomain'
                ],
                'method' => 'POST',
                'data' => [
                    'add' => [
                        [
                            'custom_fields' => [
                                [
                                    'id' => 'status_id',
                                    'values' => [
                                        ['value' => 1]
                                    ]
                                ],
                                [
                                    'id' => 123456,
                                    'values' => [
                                        ['value' => '654321']
                                    ]
                                ],
                                [
                                    'id' => 654321,
                                    'values' => [
                                        ['value' => '123456']
                                    ]
                                ]
                            ],
                            'element_type' => 1,
                            'note_type' => 1
                        ]
                    ]
                ],
                'class' => Query::class
            ],
            'responseConfig' => [
                'class' => Response::class
            ],
            'transport' => 'yii\\httpclient\\CurlTransport'
        ]);
    }
}