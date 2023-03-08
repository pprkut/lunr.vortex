<?php

/**
 * This file contains the JPushNotification3rdPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains the Base tests of the JPushNotification3rdPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload
 */
class JPushNotification3rdPayloadBaseTest extends JPushNotification3rdPayloadTest
{

    /**
     * Test elements is initialized.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::__construct
     */
    public function testElementsIsInitialized(): void
    {
        $this->assertPropertySame('elements', [
            'platform' => [ 'ios', 'android' ],
            'audience' => [],
            'notification' => [],
            'notification_3rd' => [],
            'message' => []
        ]);
    }

}

?>
