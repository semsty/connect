<?php

namespace connect\crm\amocrm\action;

use connect\crm\amocrm\action\ContactsSet as Action;
use connect\crm\tests\amocrm\TestCase;

class SetTest extends TestCase
{
    public function testRun()
    {
        $info = [
            'custom_fields' => [
                'contacts' => [
                    [
                        'id' => '000001',
                        'name' => 'stuff',
                        'code' => 'POSITION',
                        'multiple' => 'N',
                        'type_id' => '1',
                        'disabled' => '0',
                        'sort' => 3
                    ],
                    [
                        'id' => '000002',
                        'name' => 'phone',
                        'code' => 'PHONE',
                        'multiple' => 'Y',
                        'type_id' => '8',
                        'disabled' => '0',
                        'sort' => 4,
                        'enums' => [
                            '282707' => 'WORK',
                            '282709' => 'WORKDD',
                            '282711' => 'MOB',
                            '282713' => 'FAX',
                            '282715' => 'HOME',
                            '282717' => 'OTHER'
                        ]
                    ],
                    [
                        'id' => '000003',
                        'name' => 'Email',
                        'code' => 'EMAIL',
                        'multiple' => 'Y',
                        'type_id' => '8',
                        'disabled' => '0',
                        'sort' => 6,
                        'enums' => [
                            '282719' => 'WORK',
                            '282721' => 'PRIV',
                            '282723' => 'OTHER'
                        ]
                    ],
                    [
                        'id' => '000004',
                        'name' => 'messenger',
                        'code' => 'IM',
                        'multiple' => 'Y',
                        'type_id' => '8',
                        'disabled' => '0',
                        'sort' => 4,
                        'enums' => [
                            '282725' => 'SKYPE',
                            '282727' => 'ICQ',
                            '282729' => 'JABBER',
                            '282731' => 'GTALK',
                            '282733' => 'MSN',
                            '282735' => 'OTHER'
                        ]
                    ],
                    [
                        'id' => '000005',
                        'name' => 'api_phone',
                        'code' => '',
                        'multiple' => 'N',
                        'type_id' => '1',
                        'disabled' => '0',
                        'sort' => 505
                    ]
                ],
            ]
        ];
        $action = new Action([
            'login' => 'login',
            'subdomain' => 'subdomain',
            'apiKey' => '1234567890',
            'data' => [
                'add' => [
                    [
                        'status_id' => 1,
                        '000005' => '6543210',
                        'phone' => '1234567'
                    ]
                ]
            ]
        ]);
        $action->service->schema->info = $info;
        expect($action->getFieldIdByName('phone'))->equals('000002');
        expect($action->getData())->equals([
            'add' => [
                [
                    'custom_fields' => [
                        [
                            'id' => 'status_id',
                            'values' => [
                                [
                                    'value' => 1
                                ]
                            ]
                        ],
                        [
                            'id' => '000005',
                            'values' => [
                                [
                                    'value' => '6543210'
                                ]
                            ]
                        ],
                        [
                            'id' => '000002',
                            'values' => [
                                [
                                    'value' => '1234567',
                                    'enum' => 282707
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ]);
    }
}