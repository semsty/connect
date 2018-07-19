<?php

namespace connect\crm\tests\retailcrm\action;

use connect\crm\retailcrm\action\lists\Dictionaries as Action;
use connect\crm\tests\retailcrm\TestCase;

class DictionariesTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'success' => true,
            'pagination' => [
                'limit' => 20,
                'totalCount' => 5,
                'currentPage' => 1,
                'totalPageCount' => 1
            ],
            'customDictionaries' => [
                [
                    'name' => 'custom_field',
                    'code' => 'custom-fields',
                    'elements' => [
                        [
                            'name' => 'value1',
                            'code' => 'value1',
                            'ordering' => 10
                        ],
                        [
                            'name' => 'value2',
                            'code' => 'value2',
                            'ordering' => 20
                        ]
                    ]
                ]
            ]
        ]
    ];

    public function testRun()
    {
        $action = new Action([
            'apiKey' => '1234567890',
            'subdomain' => 'test',
        ]);
        $action->service->connection = $this->connection;
        $data = $action->run();
        expect($data)->equals($this->responses[Action::NAME]['customDictionaries']);
        expect($action->service->schema->getFieldConstraints('custom_field'))->equals($this->responses[Action::NAME]['customDictionaries'][0]);
    }
}
