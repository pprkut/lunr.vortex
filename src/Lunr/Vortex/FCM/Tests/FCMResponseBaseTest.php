<?php

/**
 * This file contains the FCMResponseBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the constructor of the FCMResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
class FCMResponseBaseTest extends FCMResponseTest
{

    /**
     * Test statuses is initialized as an empty array.
     */
    public function testStatusesIsInitializedAsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('statuses'));
    }

}

?>
