<?php

/**
 * This file contains the FCMPayloadHasTopicTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the has_topic method of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadHasTopicTest extends FCMPayloadTest
{

    /**
     * Test has_topic() returns FALSE when a topic is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_topic
     */
    public function testWhenNoTopicIsSet(): void
    {
        $this->assertFalse($this->class->has_topic());
    }

    /**
     * Test if has_topic() returns TRUE when a topic is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_topic
     */
    public function testWhenTopicIsSetCorrectly(): void
    {
        $this->class->set_topic('news');

        $this->assertTrue($this->class->has_topic());
    }

}

?>
