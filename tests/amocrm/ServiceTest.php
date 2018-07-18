<?php

namespace connect\crm\tests\amocrm;

use connect\crm\amocrm\action\Auth;

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
