<?php

/**
 * Class UnknownAuthProviderExceptionTest
 *
 * @group Exceptions
 * @covers Exception\UnknownAuthProviderException
 */
class UnknownAuthProviderExceptionTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testIsClassInstanceOfException()
    {
        $this->assertInstanceOf(Exception::class, new Exception\UnknownAuthProviderException());
    }
}