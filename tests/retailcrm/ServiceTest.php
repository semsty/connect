<?php

namespace connect\crm\tests\retailcrm;

class ServiceTest extends TestCase
{
    public function testInfo()
    {
        $action = $this->service->action('info');
        $data = $action->run();
        expect(is_array($data))->true();
    }
}
