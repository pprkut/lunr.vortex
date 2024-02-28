<?php

/**
 * This file contains the FCMPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains the Base tests of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadBaseTest extends FCMPayloadTest
{

    /**
     * Test elements is initialized with empty array.
     */
    public function testElementsIsInitializedWithEmptyArray(): void
    {
        $this->assertPropertySame('elements', []);
    }

    /**
     * Test android_payload is initialized with NULL.
     */
    public function testAndroidPayloadIsInitializedWithNULL(): void
    {
        $this->assertPropertySame('android_payload', NULL);
    }

    /**
     * Test apns_payload is initialized with NULL.
     */
    public function testApnsPayloadIsInitializedWithNULL(): void
    {
        $this->assertPropertySame('apns_payload', NULL);
    }

}

?>
