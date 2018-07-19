<?php

namespace connect\crm\tests\retailcrm\action;

use connect\crm\retailcrm\action\lists\Customers as Action;
use connect\crm\tests\retailcrm\TestCase;

class CustomersTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'success' => true,
            'pagination' => [
                'limit' => 20,
                'totalCount' => 1,
                'currentPage' => 1,
                'totalPageCount' => 1
            ],
            'customers' => [
                [
                    'id' => 9,
                    'firstName' => 'firstName',
                    'lastName' => 'lastName',
                    'sex' => 'female',
                    'email' => 'email@test.org',
                    'phones' => [
                        [
                            'number' => '+7 (922) 463-3191'
                        ],
                        [
                            'number' => '(812) 854-01-54'
                        ]
                    ],
                    'address' => [
                        'countryIso' => 'RU',
                        'city' => 'Самара',
                        'street' => 'Ладыгина',
                        'building' => '24',
                        'flat' => '12',
                        'text' => 'Ладыгина, д. 24, кв./офис 12'
                    ],
                    'createdAt' => '2017-06-03 19=>06=>32',
                    'managerId' => 3,
                    'bad' => false,
                    'site' => 'b12-skillum-ru',
                    'source' => [
                        'source' => '(direct)',
                        'medium' => 'search',
                        'campaign' => 'email_01'
                    ],
                    'contragent' => [
                        'contragentType' => 'individual'
                    ],
                    'personalDiscount' => 0.13,
                    'emailMarketingUnsubscribedAt' => '2018-02-28 16=>36=>28',
                    'marginSumm' => 144998,
                    'totalSumm' => 213377,
                    'averageSumm' => 53344.25,
                    'ordersCount' => 4,
                    'costSumm' => 68379,
                    'customFields' => []
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
        expect($data)->equals($this->responses[Action::NAME]['customers']);
    }
}
