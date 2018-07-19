<?php

namespace connect\crm\tests\amocrm\query;

use connect\crm\amocrm\action\LeadsList as Action;
use connect\crm\tests\amocrm\TestCase;

class ConnectionTest extends TestCase
{
    public $responses = [
        Action::NAME => [
            'consecutive' => true,
            'responses' => [
                [
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
                                'date_create' => '0000000001',
                                'account_id' => '1',
                                'created_user_id' => '1',
                                'date_close' => '0000000001'
                            ]
                        ],
                        'server_time' => '0000000001'
                    ]
                ],
                [
                    '_embedded' => [
                        'items' => []
                    ]
                ]
            ]
        ]
    ];

    public function testAll()
    {
        $action = $this->service->action(Action::ID, ['limit_rows' => 1, 'limit_offset' => 1]);
        $data = $action->run();
        expect($this->calls[Action::NAME])->equals(2);
        expect($data)->equals($this->responses[Action::NAME]['responses'][0]['_embedded']['items']);
    }

    public function testBatch()
    {
        $action = $this->service->action(Action::ID, ['limit_rows' => 1, 'limit_offset' => 1]);
        $action->isBatch = true;
        $i = 0;
        while ($chunk = $action->batch()) {
            expect($chunk)->equals($this->responses[Action::NAME]['responses'][$i]['_embedded']['items']);
        }
    }
}
