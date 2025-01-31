<?php

/**
 * This file contains the FCMApnsPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains the Base tests of the FCMApnsPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMApnsPayload
 */
class FCMApnsPayloadBaseTest extends FCMApnsPayloadTestCase
{

    /**
     * Test elements is initialized with empty array.
     */
    public function testElementsIsInitializedWithEmptyArray(): void
    {
        $this->assertPropertySame('elements', []);
    }

    /**
     * Test get_payload() returns elements array.
     *
     * @covers Lunr\Vortex\FCM\FCMApnsPayload::get_payload
     */
    public function testGetPayloadReturnsElementsArray(): void
    {
        $this->setReflectionPropertyValue('elements', $this->payload);

        $this->assertSame($this->payload, $this->class->get_payload());
    }

}

?>
