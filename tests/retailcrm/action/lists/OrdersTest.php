<?php

namespace connect\crm\tests\retailcrm\action;

use connect\crm\retailcrm\action\lists\Orders as Action;
use connect\crm\tests\retailcrm\TestCase;

class OrdersTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'success' => true,
            'pagination' => [
                'limit' => 1,
                'totalCount' => 1,
                'currentPage' => 1,
                'totalPageCount' => 1
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
        expect($data)->equals($this->responses[Action::NAME]['orders']);
    }

    public function testFilter()
    {
        $action = new Action([
            'apiKey' => '1234567890',
            'subdomain' => 'test',
        ]);
        $action->setFilter(['ids' => [1, 2]]);
        expect($action->getFilter())->equals(['ids' => [1, 2]]);
    }
}
