<?php

/**
 * This file contains the FCMBatchResponseGetStatusTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use InvalidArgumentException;
use Lunr\Vortex\FCM\FCMBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the get_status function of the FCMBatchResponse class.
 *
 * @covers Lunr\Vortex\FCM\FCMBatchResponse
 */
class FCMBatchResponseGetStatusTest extends FCMBatchResponseTestCase
{

    /**
     * Testcase constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $content = file_get_contents(TEST_STATICS . '/Vortex/fcm/response_single_success.json');

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->class = new FCMBatchResponse([ 'endpoint1' => $this->response ], $this->logger, [ 'endpoint1' ]);

        parent::baseSetUp($this->class);
    }

    /**
     * Test the get_status() returns InvalidArgumentException if wrong endpoint is provided.
     *
     * @covers Lunr\Vortex\FCM\FCMBatchResponse::get_status
     */
    public function testGetStatusReturnsException(): void
    {
        $this->setReflectionPropertyValue('statuses', [ 'endpoint1' => PushNotificationStatus::Success ]);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid endpoint: Endpoint was not part of this batch!');

        $this->class->get_status('endpoint_param');
    }

    /**
     * Test the get_status() returns unknown status if wrong endpoint is provided.
     *
     * @covers Lunr\Vortex\FCM\FCMBatchResponse::get_status
     */
    public function testGetStatusReturnsUnknown(): void
    {
        $this->setReflectionPropertyValue('statuses', [ 'endpoint1' => PushNotificationStatus::Success ]);
        $this->setReflectionPropertyValue('endpoints', [ 'endpoint1', 'endpoint_param' ]);

        $result = $this->class->get_status('endpoint_param');

        $this->assertSame(PushNotificationStatus::Unknown, $result);
    }

    /**
     * Test the get_status() succeeds.
     *
     * @covers Lunr\Vortex\FCM\FCMBatchResponse::get_status
     */
    public function testGetStatusSucceeds(): void
    {
        $this->setReflectionPropertyValue('statuses', [ 'endpoint1' => PushNotificationStatus::Success ]);

        $result = $this->class->get_status('endpoint1');

        $this->assertSame(PushNotificationStatus::Success, $result);
    }

}

?>
