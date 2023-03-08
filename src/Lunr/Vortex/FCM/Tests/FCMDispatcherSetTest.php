<?php

/**
 * This file contains the FCMDispatcherSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the setters of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherSetTest extends FCMDispatcherTest
{

    /**
     * Test that set_auth_token() sets the endpoint.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsPayload(): void
    {
        $this->class->set_auth_token('auth_token');

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference(): void
    {
        $this->assertEquals($this->class, $this->class->set_auth_token('auth_token'));
    }

}

?>
