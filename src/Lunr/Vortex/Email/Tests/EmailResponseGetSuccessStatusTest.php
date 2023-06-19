<?php

/**
 * This file contains the EmailResponseGetSuccessStatusTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the EmailResponse class.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
class EmailResponseGetSuccessStatusTest extends EmailResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpSuccess();
    }

    /**
     * Test that get_status() returns PushNotification::SUCCESS
     * for an endpoint with a succesful notification.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetSuccessStatusForEndpoint(): void
    {
        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->class->get_status('success-endpoint'));
    }

}

?>
