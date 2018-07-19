<?php

namespace connect\crm\tests\bitrix24\action;

use connect\crm\bitrix24\action\Auth;
use connect\crm\tests\bitrix24\TestCase;

class AuthTest extends TestCase
{
    public function testRun()
    {
        $action = $this->service->action(Auth::NAME);
        $action->run();
        expect($this->profile->config['refresh_token'])->equals('0987654321');
        expect($this->profile->config['access_token'])->equals('0987654321');
        expect($this->profile->config['expires_in'])->notEquals(3600);
    }
}
