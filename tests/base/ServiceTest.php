<?php

namespace connect\crm\tests\base;

class ServiceTest extends TestCase
{
    public function testDictionaries()
    {
        $dict = $this->service->getDict('service.attributes');
        expect($dict)->notEmpty();
    }
}
