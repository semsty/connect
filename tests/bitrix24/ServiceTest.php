<?php

namespace connect\crm\tests\bitrix24;

use connect\crm\bitrix24\action\Auth;

class ServiceTest extends TestCase
{
    public function testAuth()
    {
        $expected = $this->getResponses()[Auth::NAME];
        $action = $this->service->action(Auth::ID);
        $data = $action->run();
        expect(is_array($data))->true();
        $expected['expires_in'] = strtotime('now') + $expected['expires_in'];
        expect($action->profile->config)->equals($expected + ['expires' => 0]);
    }
}
