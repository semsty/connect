<?php

namespace tests\base;

use semsty\connect\base\Service;

class ServiceTest extends TestCase
{
    public function testDictionaries()
    {
        $dict = $this->service->getDict('service.attributes');
        expect($dict)->notEmpty();
    }
}
