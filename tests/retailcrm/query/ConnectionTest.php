<?php

namespace connect\crm\tests\retailcrm\query;

use connect\crm\base\helpers\ArrayHelper;
use connect\crm\retailcrm\action\lists\Orders as Action;
use connect\crm\tests\retailcrm\TestCase;

class ConnectionTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'consecutive' => true,
            'responses' => [
                [
                    'success' => true,
                    'pagination' => [
                        'limit' => 1,
                        'totalCount' => 1,
                        'currentPage' => 1,
                        'totalPageCount' => 2
                    ],
                    'orders' => [
                        [
                            'paymentType' => 'type',
                            'paymentStatus' => 'status',
                            'slug' => 1,
                            'summ' => 1,
                            'totalSumm' => 1,
                            'id' => 1,
                            'number' => '1',
                            'externalId' => '1',
                            'source' => [
                                'source' => 'source',
                                'medium' => 'medium',
                                'campaign' => 'campaign',
                                'content' => 'content',
                                'keyword' => 'keyword'
                            ]
                        ]
                    ]
                ],
                [
                    'success' => true,
                    'pagination' => [
                        'limit' => 1,
                        'totalCount' => 1,
                        'currentPage' => 2,
                        'totalPageCount' => 2
                    ],
                    'orders' => []
                ]
            ]
        ]
    ];

    public function testAll()
    {
        $action = $this->service->action(Action::ID);
        $data = $action->run();
        expect($this->calls[Action::NAME])->equals(2);
        expect($data)->equals($this->responses[Action::NAME]['responses'][0]['orders']);
    }

    public function testBatch()
    {
        $action = $this->service->action(Action::ID);
        $action->isBatch = true;
        $i = 0;
        while ($chunk = $action->batch()) {
            expect($chunk)->equals($this->responses[Action::NAME]['responses'][$i]['orders']);
        }
    }
}
