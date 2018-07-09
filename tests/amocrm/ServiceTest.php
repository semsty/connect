<?php

namespace tests\amocrm;

use semsty\connect\amocrm\actions\Auth;

class ServiceTest extends TestCase
{
    public function testAuth()
    {
        $action = $this->service->action(Auth::ID);
        $data = $action->run();
        expect(is_array($data))->true();
        expect(file_exists(\Yii::getAlias('@connect_log/amocrm/imanicelittletoken/cookie.txt')))->true();
    }
}
