<?php

/**
 * This file contains the APNSResponseBasePushErrorTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;
use Lunr\Vortex\PushNotificationStatus;
use ReflectionClass;

/**
 * This class contains tests for the constructor of the APNSResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
class APNSResponseBasePushErrorTest extends APNSResponseTest
{

    /**
     * Test constructor behavior for error of push notification with no invalid endpoint.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushErrorWithNoInvalidEndpoint(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4' ];
        $invalid_endpoints = [];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::ERROR,
            'endpoint3' => PushNotificationStatus::ERROR,
            'endpoint4' => PushNotificationStatus::ERROR,
        ];

        $this->class = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, NULL, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for error of push notification with some invalid endpoints.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushErrorWithSomeInvalidEndpoints(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4' ];
        $invalid_endpoints = [ 'endpoint2', 'endpoint4' ];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint3' => PushNotificationStatus::ERROR,
            'endpoint4' => PushNotificationStatus::INVALID_ENDPOINT,
        ];

        $this->class = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, NULL, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertyEquals('statuses', $statuses);
    }

}

?>
