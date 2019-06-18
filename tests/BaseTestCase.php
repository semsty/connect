<?php

namespace connect\crm\tests;

/**
 * Class TestCase
 * @property $connection
 * @property $profile
 * @property $service
 * @package connect\crm\tests
 */
abstract class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    use BaseTestCaseTrait;

    protected function tearDown(): void
    {
        $this->caseTearDown();
        parent::tearDown();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->caseSetUp();
    }

    public function getResponses()
    {
        return $this->responses;
    }
}
