<?php

/**
 * This file contains the PushNotificationDispatcherSetupTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Tests;

/**
 * This class contains tests for the setup functions of the PushNotificationDispatcher class.
 *
 * @covers Lunr\Vortex\PushNotificationDispatcher
 */
class PushNotificationDispatcherSetupTest extends PushNotificationDispatcherTest
{

    /**
     * Test adding dispatchers.
     *
     * @covers Lunr\Vortex\PushNotificationDispatcher::register_dispatcher
     */
    public function testRegisterDispatcher(): void
    {
        $property = $this->get_accessible_reflection_property('dispatchers');
        $before   = $property->getValue($this->class);

        $this->assertArrayEmpty($before);

        $this->class->register_dispatcher('wns', $this->wns);
        $this->class->register_dispatcher('fcm', $this->fcm);

        $after = $property->getValue($this->class);

        $this->assertArrayHasKey('wns', $after);
        $this->assertArrayHasKey('fcm', $after);
        $this->assertSame($this->wns, $after['wns']);
        $this->assertSame($this->fcm, $after['fcm']);
    }

}

?>
