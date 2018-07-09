<?php

namespace tests\amocrm;

use semsty\connect\amocrm\actions\Auth;

class ServiceTest extends TestCase
{
    public function testResponse()
    {
        $action = $this->service->action(Auth::ID);
        $data = $action->run();
        expect(is_array($data))->true();
    }
}
