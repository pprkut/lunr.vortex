<?php

/**
 * This file contains the JPushResponseGetStatusTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the get_status function of the JPushResponse class.
 *
 * @covers Lunr\Vortex\JPush\JPushResponse
 */
class JPushResponseGetStatusTest extends JPushResponseTest
{

    /**
     * Unit test data provider.
     *
     * @return array $data array of endpoints statuses / status result
     */
    public function endpointDataProvider(): array
    {
        $data = [];

        // return unknown status if no status set
        $data[] = [ [], PushNotificationStatus::UNKNOWN ];

        // return unknown status if endpoint absent
        $data[] = [
            [
                'endpoint1' => [
                    'status' => PushNotificationStatus::INVALID_ENDPOINT,
                    'batch'  => 165468564
                ],
            ],
            PushNotificationStatus::UNKNOWN,
        ];
        $data[] = [
            [
                'endpoint1' => [
                    'status' => PushNotificationStatus::ERROR,
                    'batch'  => 165468564
                ],
                'endpoint2' => [
                    'status' => PushNotificationStatus::INVALID_ENDPOINT,
                    'batch'  => 165468564
                ],
                'endpoint3' => [
                    'status' => PushNotificationStatus::SUCCESS,
                    'batch'  => 165468564
                ],
            ],
            PushNotificationStatus::UNKNOWN,
        ];

        // return unknown if status was not set
        $data[] = [
            [
                'endpoint_param' => [
                    'batch'  => 165468564
                ],
            ],
            PushNotificationStatus::UNKNOWN,
        ];

        // return endpoint own status if present
        $data[] = [
            [
                'endpoint_param' => [
                    'status' => PushNotificationStatus::INVALID_ENDPOINT,
                    'batch'  => 165468564
                ],
            ],
            PushNotificationStatus::INVALID_ENDPOINT,
        ];
        $data[] = [
            [
                'endpoint1'      => [
                    'status' => PushNotificationStatus::ERROR,
                    'batch'  => 165468564
                ],
                'endpoint_param' => [
                    'status' => PushNotificationStatus::SUCCESS,
                    'batch'  => 165468564
                ],
                'endpoint2'      => [
                    'status' => PushNotificationStatus::INVALID_ENDPOINT,
                    'batch'  => 165468564
                ],
            ],
            PushNotificationStatus::SUCCESS,
        ];

        return $data;
    }

    /**
     * Test the get_status() behavior.
     *
     * @param array $statuses Endpoints statuses
     * @param int   $status   Expected function result
     *
     * @dataProvider endpointDataProvider
     * @covers       Lunr\Vortex\JPush\JPushResponse::get_status
     */
    public function testGetStatus($statuses, $status): void
    {
        $this->set_reflection_property_value('statuses', $statuses);

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals($status, $result);
    }

}

?>
