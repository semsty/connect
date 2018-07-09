<?php

namespace tests\base;

use semsty\connect\base\Action;
use semsty\connect\base\Profile;
use semsty\connect\base\Service;
use semsty\connect\base\Session;

class ServiceProfileModelTest extends TestCase
{
    public function testProfile()
    {
        expect($this->profile->service->profile)->equals($this->profile);
        $action = $this->profile->service->action(Action::ID);
        expect($action->service)->equals($this->profile->service);
        expect($action->profile)->equals($this->profile);
    }

    public function testService()
    {
        $service = new Service(['profile' => $this->profile]);
        expect($service->profile)->equals($this->profile);
        expect($this->profile->service)->equals($service);
        $action = $service->action(Action::ID);
        expect($action->service)->equals($this->profile->service);
        expect($action->profile)->equals($this->profile);
    }

    public function testSession()
    {
        $service = new Service(['profile' => $this->profile]);
        expect($service->session->id)->equals(Session::find()->one()->id);
        expect($service->session->is_active)->true();
        $service->destructSession();
        $session = Session::find()->one();
        expect($session->is_active)->false();
    }

    protected function setUp()
    {
        $this->profile = new Profile([
            'config' => [
                'subdomain' => 'subdomain',
                'apiKey' => 'apiKey',
                'login' => 'login'
            ],
            'service_id' => 0
        ]);
        $this->profile->save();
    }
}
