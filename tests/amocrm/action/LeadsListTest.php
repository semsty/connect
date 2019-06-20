<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\LeadsList as Action;
use connect\crm\amocrm\query\Query;
use connect\crm\amocrm\query\Response;
use connect\crm\tests\amocrm\TestCase;
use yii\helpers\ArrayHelper;

class LeadsListTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            '_embedded' => [
                'items' => [
                    [
                        'id' => '1',
                        'name' => 'name',
                        'last_modified' => '0000000001',
                        'status_id' => '142',
                        'price' => '500000',
                        'linked_company_id' => '1',
                        'responsible_user_id' => '1',
                        'pipeline_id' => 1,
                        'closest_task' => 1,
                        'main_contact_id' => 1,
                        'tags' => [
                            [
                                'id' => '1',
                                'name' => 'USA'
                            ],
                            [
                                'id' => '2',
                                'name' => 'Lead'
                            ]
                        ],
                        'date_create' => '0000000001',
                        'account_id' => '1',
                        'created_user_id' => '1',
                        'custom_fields' => [
                            [
                                'id' => '1',
                                'name' => 'utm_medium',
                                'values' => [
                                    [
                                        'value' => 'utm_medium'
                                    ]
                                ]
                            ],
                            [
                                'id' => '2',
                                'name' => 'utm_source',
                                'values' => [
                                    [
                                        'value' => 'utm_source'
                                    ]
                                ]
                            ],
                            [
                                'id' => '3',
                                'name' => 'utm_campaign',
                                'values' => [
                                    [
                                        'value' => 'utm_campaign'
                                    ]
                                ]
                            ],
                            [
                                'id' => '4',
                                'name' => 'utm_content',
                                'values' => [
                                    [
                                        'value' => 'utm_content'
                                    ]
                                ]
                            ],
                            [
                                'id' => '5',
                                'name' => 'utm_term',
                                'values' => [
                                    [
                                        'value' => 'utm_term'
                                    ]
                                ]
                            ]
                        ],
                        'date_close' => '0000000001'
                    ]
                ],
                'server_time' => '0000000001'
            ]
        ]
    ];

    public function testRun()
    {
        $action = $this->service->action(Action::ID);
        $action->modifiedSince = '2017-01-01';
        expect($action->config)->equals([
            'baseUrl' => 'https://{subdomain}.amocrm.ru/',
            'requestConfig' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'if-modified-since' => ArrayHelper::getValue($action->config, 'requestConfig.headers.if-modified-since')
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
                    '0' => 'https://{subdomain}.amocrm.ru/api/{version}/leads',
                    'query' => [],
                    'responsible_user_id' => null,
                    'id' => null,
                    'version' => 'v2',
                    'subdomain' => 'subdomain',
                    'filter' => []
                ],
                'method' => 'GET',
                'class' => Query::class
            ],
            'responseConfig' => [
                'class' => Response::class
            ],
            'rateLimit' => [
                1,
                5
            ],
            'limit_request_key' => 'limit_rows',
            'offset_request_key' => 'limit_offset',
            'offset_response_key' => '_embedded.items',
            'max_limit' => null,
            'max_offset' => 0,
            'offset_increment' => null,
            'current_offset' => 0,
            'cursor' => '_embedded.items',
            'transport' => 'yii\\httpclient\\CurlTransport'
        ]);
        $result = $action->run();
        expect($result)->equals($this->responses[Action::NAME]['_embedded']['items']);
    }
}