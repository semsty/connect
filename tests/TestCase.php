<?php

namespace connect\crm\tests;

use Codeception\Util\Stub;
use connect\crm\base\BaseService;
use connect\crm\base\exception\InvalidConfiguration;
use connect\crm\base\helpers\ArrayHelper;
use connect\crm\base\Profile;
use connect\crm\base\query\Connection;
use connect\crm\base\query\Query;
use connect\crm\base\query\Response;
use connect\crm\base\Session;

/**
 * Class TestCase
 * @property $connection
 * @property $profile
 * @property $service
 * @package tests
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public $_connection_class = Connection::class;
    public $_service_class = BaseService::class;
    public $_profile_class = Profile::class;
    public $connection;
    public $request;
    public $responses = [];
    public $profile_config = [];

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
                    $manager = $this->connection->owner;
                    if ($manager && defined(get_class($manager) . '::NAME')) {
                        $response = ArrayHelper::getValue($this->getResponses(), $manager::NAME, []);
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
