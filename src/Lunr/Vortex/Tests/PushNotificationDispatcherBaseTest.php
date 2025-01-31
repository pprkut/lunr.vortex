<?php

/**
 * This file contains the PushNotificationDispatcherBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Tests;

/**
 * This class contains test for the constructor of the PushNotificationDispatcher class.
 *
 * @covers Lunr\Vortex\PushNotificationDispatcher
 */
class PushNotificationDispatcherBaseTest extends PushNotificationDispatcherTestCase
{

    /**
     * Test that the dispatchers list is set to an empty array by default.
     */
    public function testDispatchersIsEmptyArray(): void
    {
        $this->assertPropertyEquals('dispatchers', []);
    }

}

?>
