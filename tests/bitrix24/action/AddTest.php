<?php

namespace connect\crm\tests\bitrix24\action;

use connect\crm\bitrix24\action\Add as Action;
use connect\crm\tests\bitrix24\TestCase;
use yii\base\ErrorException;

class AddTest extends TestCase
{
    public function testRun()
    {
        $info = [
            'deal' => [
                'ID' => [
                    'type' => 'integer',
                    'isRequired' => false,
                    'isReadOnly' => true,
                    'isImmutable' => false,
                    'isMultiple' => false,
                    'isDynamic' => false
                ],
                'NAME' => [
                    'type' => 'string',
                    'isRequired' => true,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => false,
                    'isDynamic' => false
                ],
                'PHONE' => [
                    'type' => 'crm_multifield',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => true,
                    'isDynamic' => false
                ],
                'EMAIL' => [
                    'type' => 'crm_multifield',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => true,
                    'isDynamic' => false
                ],
                'UF_CRM_0000000000001' => [
                    'type' => 'string',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => false,
                    'isDynamic' => true,
                    'listLabel' => 'Custom Char Field',
                    'formLabel' => 'Custom Char Field',
                    'filterLabel' => '',
                ],
                'UF_CRM_0000000000002' => [
                    'type' => 'string',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => true,
                    'isDynamic' => true,
                    'listLabel' => 'Custom Multi Field',
                    'formLabel' => 'Custom Multi Field',
                    'filterLabel' => '',
                ],
                'UF_CRM_0000000000003' => [
                    'type' => 'enumeration',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => true,
                    'isDynamic' => true,
                    'items' => [
                        [
                            'ID' => '1',
                            'VALUE' => 'first',
                        ],
                        [
                            'ID' => '2',
                            'VALUE' => 'second',
                        ],
                    ],
                    'listLabel' => 'Custom Multi Enum Field',
                    'formLabel' => 'Custom Multi Enum Field',
                    'filterLabel' => '',
                ],
                'UF_CRM_0000000000004' => [
                    'type' => 'enumeration',
                    'isRequired' => false,
                    'isReadOnly' => false,
                    'isImmutable' => false,
                    'isMultiple' => false,
                    'isDynamic' => true,
                    'items' => [
                        [
                            'ID' => '3',
                            'VALUE' => 'first',
                        ],
                        [
                            'ID' => '4',
                            'VALUE' => 'second',
                        ],
                    ],
                    'listLabel' => 'Custom Enum Field',
                    'formLabel' => 'Custom Enum Field',
                    'filterLabel' => '',
                ],
            ]
        ];

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'name' => 'vasya',
                'custom Char field' => '6543210',
                'UF_CRM_0000000000002' => '1234567',
                'UF_CRM_0000000000003' => 'first',
                'UF_CRM_0000000000004' => 'second'
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        expect($action->getFieldName('custom multi enum field'))->equals('UF_CRM_0000000000003');
        expect($action->getData())->equals([
            'fields' => [
                'NAME' => 'vasya',
                'UF_CRM_0000000000001' => '6543210',
                'UF_CRM_0000000000002' => ['1234567'],
                'UF_CRM_0000000000003' => ['1'],
                'UF_CRM_0000000000004' => '4'
            ]
        ]);

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'name' => 'vasya',
                'custom Char field' => '6543210',
                'UF_CRM_0000000000002' => ['1234567', '2345678', '3456789'],
                'UF_CRM_0000000000003' => ['first', 'second'],
                'UF_CRM_0000000000004' => 'second'
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        expect($action->getData())->equals([
            'fields' => [
                'NAME' => 'vasya',
                'UF_CRM_0000000000001' => '6543210',
                'UF_CRM_0000000000002' => ['1234567', '2345678', '3456789'],
                'UF_CRM_0000000000003' => ['1', '2'],
                'UF_CRM_0000000000004' => '4'
            ]
        ]);

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'custom Char field' => ['6543210']
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        try {
            $action->getData();
        } catch (ErrorException $e) {
            expect($e->getMessage())->equals('Field UF_CRM_0000000000001 not multiple');
        }

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'UF_CRM_0000000000003' => 'ololo'
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        try {
            $action->getData();
        } catch (ErrorException $e) {
            expect($e->getMessage())->equals('Value ololo does not exist in list field UF_CRM_0000000000003');
        }

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'ID' => 666
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        try {
            $action->getData();
        } catch (ErrorException $e) {
            expect($e->getMessage())->equals('Field ID is read only');
        }

        $action = new Action([
            'auth' => 'littlenicetoken',
            'domain' => 'subdomain.bitrix24.ru',
            'data' => [
                'nOt_eXiSt' => 666
            ],
            'with_info' => false,
            'with_auth' => false
        ]);
        $action->service->schema->info = $info;
        try {
            $action->getData();
        } catch (ErrorException $e) {
            expect($e->getMessage())->equals('Field NOT_EXIST does not exists in deal');
        }
    }
}
