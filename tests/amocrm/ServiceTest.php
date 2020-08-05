<?php

namespace connect\crm\tests\amocrm;

use connect\crm\amocrm\action\Access;
use connect\crm\amocrm\action\Auth;

class ServiceTest extends TestCase
{
    public function testRandomAuth()
    {
        $this->responses[Auth::NAME] = [
            'consecutive' => true,
            'responses' => [
                [
                    'responseConfig' => [
                        'data' => [
                            'response' => [
                                'error_code' => '110',
                                'error' => 'Неверный логин или пароль',
                                'ip' => '88.212.240.252',
                                'domain' => 'test.amocrm.ru',
                                'auth' => false,
                                'server_time' => 0
                            ],
                        ],
                        'headers' => [
                            'http-code' => 401
                        ]
                    ]
                ],
                [
                    'responseConfig' => [
                        'data' => [
                            'response' => [
                                'error_code' => '110',
                                'error' => 'Неверный логин или пароль',
                                'ip' => '88.212.240.252',
                                'domain' => 'test.amocrm.ru',
                                'auth' => false,
                                'server_time' => 0
                            ],
                        ],
                        'headers' => [
                            'http-code' => 401
                        ]
                    ]
                ],
                [
                    'response' => [
                        'auth' => true,
                        'accounts' => [
                            [
                                'id' => '666',
                                'name' => '666',
                                'subdomain' => 'test',
                                'language' => 'ru',
                                'timezone' => 'Europe/Moscow',
                            ],
                        ],
                        'user' => [
                            'id' => '666',
                            'language' => 'ru',
                        ],
                        'server_time' => 0,
                    ]
                ]
            ]
        ];
        $action = $this->service->action(Auth::NAME);
        $data = $action->run();
        expect($action->random_retry_attempts)->equals(3);
    }
}
