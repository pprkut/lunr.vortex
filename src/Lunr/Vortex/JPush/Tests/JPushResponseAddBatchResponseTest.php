<?php

/**
 * This file contains the JPushResponseAddBatchResponseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the add_batch_response function of the JPushResponse class.
 *
 * @covers Lunr\Vortex\JPush\JPushResponse
 */
class JPushResponseAddBatchResponseTest extends JPushResponseTest
{

    /**
     * Test that add_batch_response() with no endpoint doesn't modify the statuses and batches property.
     *
     * @covers  Lunr\Vortex\JPush\JPushResponse::add_batch_response
     */
    public function testAddBatchResponseWithNoEndpointDoesNotModifyStatusesAndBatches(): void
    {
        $statuses = [
            'endpoint1' => PushNotificationStatus::Error,
            'endpoint2' => PushNotificationStatus::Success,
        ];

        $this->set_reflection_property_value('statuses', $statuses);

        $this->batch_response->expects($this->once())
                             ->method('get_message_id')
                             ->willReturn(NULL);

        $this->batch_response->expects($this->never())
                             ->method('get_status');

        $this->class->add_batch_response($this->batch_response, []);

        $this->assertPropertySame('statuses', $statuses);
    }

    /**
     * Test that add_batch_response() with endpoints add status for each of them.
     *
     * @covers  Lunr\Vortex\JPush\JPushResponse::add_batch_response
     */
    public function testAddBatchResponseWithEndpointsAddStatus(): void
    {
        $statuses = [
            'endpoint1' => [
                'status'     => PushNotificationStatus::Error,
                'message_id' => '165468151',
            ],
            'endpoint2' => [
                'status'     => PushNotificationStatus::Success,
                'message_id' => '165468151',
            ],
        ];

        $endpoints = [ 'endpoint2', 'endpoint3', 'endpoint4' ];

        $expected_statuses = [
            'endpoint1' => [
                'status'     => PushNotificationStatus::Error,
                'message_id' => '165468151',
            ],
            'endpoint2' => [
                'status'     => PushNotificationStatus::InvalidEndpoint,
                'message_id' => '165468564',
            ],
            'endpoint3' => [
                'status'     => PushNotificationStatus::Unknown,
                'message_id' => '165468564',
            ],
            'endpoint4' => [
                'status'     => PushNotificationStatus::Success,
                'message_id' => '165468564',
            ],
        ];

        $this->set_reflection_property_value('statuses', $statuses);

        $this->batch_response->expects($this->once())
                             ->method('get_message_id')
                             ->willReturn(165468564);

        $this->batch_response->expects($this->exactly(3))
                             ->method('get_status')
                             ->willReturnMap(
                                 [
                                     [ 'endpoint2', PushNotificationStatus::InvalidEndpoint ],
                                     [ 'endpoint3', PushNotificationStatus::Unknown ],
                                     [ 'endpoint4', PushNotificationStatus::Success ],
                                 ]
                             );

        $this->class->add_batch_response($this->batch_response, $endpoints);

        $this->assertPropertySame('statuses', $expected_statuses);
    }

}

?>
