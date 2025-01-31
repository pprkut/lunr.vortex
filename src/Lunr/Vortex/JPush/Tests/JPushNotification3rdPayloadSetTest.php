<?php

/**
 * This file contains the JPushNotification3rdPayloadSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the setters of the JPushNotification3rdPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload
 */
class JPushNotification3rdPayloadSetTest extends JPushNotification3rdPayloadTestCase
{

    /**
     * Test set_sound() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::set_sound
     */
    public function testSetSound(): void
    {
        $this->class->set_sound('sound');

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('sound', $value['notification_3rd']);
        $this->assertEquals('sound', $value['notification_3rd']['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

}

?>
