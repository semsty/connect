<?php

namespace connect\crm\tests;

use Codeception\Util\Stub;
use connect\crm\base\exception\InvalidConfiguration;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile;
use connect\crm\base\query\Connection;
use connect\crm\base\query\Query;
use connect\crm\base\query\Response;
use connect\crm\base\Service;
use connect\crm\base\Session;

/**
 * Class TestCase
 * @property $connection
 * @property $profile
 * @property $service
 * @package tests
 */
abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    public $_connection_class = Connection::class;
    public $_service_class = Service::class;
    public $_profile_class = Profile::class;
    public $connection;
    public $request;
    public $responses = [];
    public $profile_config = [];
    public $calls = [];

    protected function tearDown()
    {
        Profile::deleteAll();
        Session::deleteAll();
        parent::tearDown();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->request = Stub::make(
            Query::class,
            [
                'send' => Stub::atLeastOnce(function () {
                    $owner = $this->connection->owner;
                    if ($owner && defined(get_class($owner) . '::NAME')) {
                        $current = ArrayHelper::getValue($this->calls, $owner::NAME, 0);
                        ArrayHelper::setValue($this->calls, $owner::NAME, ++$current);
                        $response = ArrayHelper::getValue($this->getResponses(), $owner::NAME, []);
                        if (ArrayHelper::getValue($response, 'consecutive')) {
                            $responses = ArrayHelper::getValue($response, 'responses');
                            $response = $responses[$current - 1];
                        } else {
                            if ($current > 1) {
                                return new Response([
                                    'data' => [],
                                    'headers' => [
                                        'http-code' => 200
                                    ]
                                ]);
                            }
                        }
                    } else {
                        $response = $this->getResponses()[0];
                    }
                    return new Response([
                        'data' => $response,
                        'headers' => [
                            'http-code' => 200
                        ]
                    ]);
                }),
            ]
        );
        $connection_class = $this->_connection_class;
        $this->connection = Stub::make(
            $connection_class,
            [
                'send' => Stub::atLeastOnce(function () {
                    return new Response([
                        'data' => $this->getResponses()
                    ]);
                }),
                'createRequest' => Stub::atLeastOnce(function () {
                    return $this->request;
                }),
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
