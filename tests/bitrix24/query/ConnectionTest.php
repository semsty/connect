<?php

namespace connect\crm\tests\bitrix24\query;

use connect\crm\bitrix24\action\ListAction as Action;
use connect\crm\tests\bitrix24\TestCase;

class ConnectionTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'consecutive' => true,
            'responses' => [
                [
                    'start' => 0,
                    'next' => 100,
                    'result' => [
                        [
                            'ID' => 1
                        ]
                    ]
                ],
                [
                    'start' => 100,
                    'next' => 200,
                    'result' => []
                ]
            ]
        ]
    ];

    public function testAll()
    {
        $action = $this->service->action(Action::ID);
        $data = $action->run();
        expect($this->calls[Action::NAME])->equals(2);
        expect($data)->equals($this->responses[Action::NAME]['responses'][0]['result']);
    }

    public function testBatch()
    {
        $action = $this->service->action(Action::ID);
        $i = 0;
        while ($chunk = $action->batch()) {
            expect($chunk)->equals($this->responses[Action::NAME]['responses'][$i]['result']);
        }
    }
}
