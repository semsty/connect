<?php

namespace connect\crm\tests;

use Codeception\Util\Stub;
use Codeception\Stub\Expected;
use connect\crm\base\exception\InvalidConfiguration;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile;
use connect\crm\base\query\Connection;
use connect\crm\base\query\Query;
use connect\crm\base\query\Response;
use connect\crm\base\Service;
use connect\crm\base\Session;

class ErrorHandler
{
    public function handle($error, $context = [])
    {
        return true;
    }
}

trait BaseTestCaseTrait
{
    public $_connection_class = Connection::class;
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $connection;
    public $request;
    public $responses = [];
    public $profile_config = [];
    public $calls = [];

    protected function caseTearDown()
    {
        Profile::deleteAll();
        Session::deleteAll();
    }

    protected function caseSetUp()
    {
        $this->request = Stub::make(
            Query::class,
            [
                'send' => Expected::atLeastOnce(function () {
                    $owner = $this->connection->owner;
                    if ($owner && defined(get_class($owner) . '::NAME')) {
                        $current = ArrayHelper::getValue($this->calls, $owner::NAME, 0);
                        ArrayHelper::setValue($this->calls, $owner::NAME, ++$current);
                        $response = ArrayHelper::getValue($this->getResponses(), $owner::NAME, []);
                        if (ArrayHelper::getValue($response, 'consecutive')) {
                            $responses = ArrayHelper::getValue($response, 'responses');
                            $response = ArrayHelper::getValue($responses, $current - 1, []);
                        } elseif ($current > 1) {
                            return new Response([
                                'data' => [],
                                'headers' => [
                                    'http-code' => 200
                                ]
                            ]);
                        }
                    } else {
                        $response = $this->getResponses()[0];
                    }
                    if ($config = ArrayHelper::getValue($response, 'responseConfig')) {
                        return new Response($config);
                    } else {
                        return new Response([
                            'data' => $response,
                            'headers' => [
                                'http-code' => 200
                            ]
                        ]);
                    }
                }),
            ]
        );
        $connection_class = $this->_connection_class;
        $this->connection = Stub::make(
            $connection_class,
            [
                'send' => Expected::atLeastOnce(function () {
                    return new Response([
                        'data' => $this->getResponses()
                    ]);
                }),
                'createRequest' => Expected::atLeastOnce(function () {
                    return $this->request;
                }),
                'getErrorHandler' => Expected::atLeastOnce(function () {
                    return new ErrorHandler();
                })
            ]
        );
        $service_class = $this->_service_class;
        $this->service = new $service_class();
        $profile_class = $this->_profile_class;
        $this->profile = new $profile_class(
            ArrayHelper::merge([
                'service_id' => $service_class::ID,
                'title' => 'testprofile'
            ], $this->profile_config)
        );
        $this->profile->save();
        if ($this->profile->errors) {
            throw new InvalidConfiguration(json_encode($this->profile->errors, JSON_PRETTY_PRINT));
        }
        $this->service->profile = $this->profile;
        $this->service->connection = $this->connection;
    }

    public function getResponses()
    {
        return $this->responses;
    }
}
