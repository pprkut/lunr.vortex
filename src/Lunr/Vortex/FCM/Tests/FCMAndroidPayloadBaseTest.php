<?php

/**
 * This file contains the FCMAndroidPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMAndroidPriority;

/**
 * This class contains the Base tests of the FCMAndroidPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMAndroidPayload
 */
class FCMAndroidPayloadBaseTest extends FCMAndroidPayloadTest
{

    /**
     * Test elements is initialized with empty array.
     */
    public function testElementsIsInitializedWithEmptyArray(): void
    {
        $this->assertPropertySame('elements', [ 'priority' => FCMAndroidPriority::High->value ]);
    }

    /**
     * Test get_payload() returns elements array.
     *
     * @covers Lunr\Vortex\FCM\FCMAndroidPayload::get_payload
     */
    public function testGetPayloadReturnsElementsArray(): void
    {
        $this->set_reflection_property_value('elements', $this->payload);

        $this->assertSame($this->payload, $this->class->get_payload());
    }

}

?>
