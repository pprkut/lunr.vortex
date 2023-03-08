<?php

/**
 * This file contains the FCMPayloadHasConditionTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the has_condition method of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadHasConditionTest extends FCMPayloadTest
{

    /**
     * Test has_condition() returns FALSE when no condition is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_condition
     */
    public function testWhenNoConditionIsSet(): void
    {
        $this->assertFalse($this->class->has_condition());
    }

    /**
     * Test if has_condition() returns TRUE when condition is set.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::has_condition
     */
    public function testWhenConditionIsSetCorrectly(): void
    {
        $this->class->set_condition("'TopicA' in topics && 'TopicB' in topics");

        $this->assertTrue($this->class->has_condition());
    }

}

?>
