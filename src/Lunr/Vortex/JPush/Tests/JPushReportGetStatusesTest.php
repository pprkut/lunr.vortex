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
class JPushReportGetStatusesTest extends JPushReportTest
{

    /**
     * Test that get_status returns status.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_status
     */
    public function testGetStatusReturnsStatus(): void
    {
        $this->set_reflection_property_value('statuses', [ 'endpoint1' => 1 ]);

        $result = $this->class->get_status('endpoint1');

        $this->assertSame(PushNotificationStatus::SUCCESS, $result);
    }

    /**
     * Test that get_status returns UNKNOWN status if endpoint does not exists
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_status
     */
    public function testGetStatusReturnsUnknownIfEndpointDoesNotExists(): void
    {
        $this->set_reflection_property_value('statuses', [ 'endpoint1' => 1 ]);

        $result = $this->class->get_status('endpoint_unknown');

        $this->assertSame(PushNotificationStatus::UNKNOWN, $result);
    }

}

?>
