<?php

namespace connect\crm\tests;

/**
 * Class TestCase
 * @property $connection
 * @property $profile
 * @property $service
 * @package connect\crm\tests
 */
abstract class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    use BaseTestCaseTrait;

    protected function tearDown()
    {
        $this->caseTearDown();
        parent::tearDown();
    }

    protected function setUp()
    {
        parent::setUp();
        $this->caseSetUp();
    }

    public function getResponses()
    {
        return $this->responses;
    }
}
