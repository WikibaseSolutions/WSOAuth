<?php

/**
 * Class UnknownAuthProviderExceptionTest
 *
 * @group Exceptions
 * @covers Exception\UnknownAuthProviderException
 */
class UnknownAuthProviderExceptionTest extends MediaWikiTestCase
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