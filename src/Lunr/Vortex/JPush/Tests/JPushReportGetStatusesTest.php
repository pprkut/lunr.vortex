<?php

/**
 * This file contains the JPushReportGetStatusesTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains test for the constructor of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportGetStatusesTest extends JPushReportTestCase
{

    /**
     * Test that get_status returns status.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_status
     */
    public function testGetStatusReturnsStatus(): void
    {
        $this->setReflectionPropertyValue('statuses', [ 'endpoint1' => PushNotificationStatus::Success ]);

        $result = $this->class->get_status('endpoint1');

        $this->assertSame(PushNotificationStatus::Success, $result);
    }

    /**
     * Test that get_status returns UNKNOWN status if endpoint does not exists
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_status
     */
    public function testGetStatusReturnsUnknownIfEndpointDoesNotExists(): void
    {
        $this->setReflectionPropertyValue('statuses', [ 'endpoint1' => PushNotificationStatus::Success ]);

        $result = $this->class->get_status('endpoint_unknown');

        $this->assertSame(PushNotificationStatus::Unknown, $result);
    }

}

?>
