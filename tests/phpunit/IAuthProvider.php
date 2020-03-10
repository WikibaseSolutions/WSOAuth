<?php

include_once __DIR__ . '/bootstrap.php';

/**
 * Interface IAuthProvider
 *
 * Interface for unit testing AuthenticationProvider classes.
 */
interface IAuthProvider
{
    public function testIsClassInstanceOfAuthProvider();
}