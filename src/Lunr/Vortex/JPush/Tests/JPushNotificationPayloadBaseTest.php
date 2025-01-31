<?php

/**
 * This file contains the JPushPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains the Base tests of the JPushPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotificationPayload
 */
class JPushNotificationPayloadBaseTest extends JPushNotificationPayloadTestCase
{

    /**
     * Test elements is initialized with high priority.
     */
    public function testElementsIsInitializedWithHighPriority(): void
    {
        $this->assertPropertySame('elements', [
            'platform' => [ 'ios', 'android' ],
            'audience' => [],
            'notification' => [
                'android' => [ 'priority' => 2 ],
            ],
            'notification_3rd' => [],
            'message' => []
        ]);
    }

}

?>
