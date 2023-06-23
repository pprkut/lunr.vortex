<?php

/**
 * This file contains the JPushResponseGetMessageIdTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Brian Stoop <brian.stoop@moveagency.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the get_message_id function of the JPushResponse class.
 *
 * @covers Lunr\Vortex\JPush\JPushResponse
 */
class JPushResponseGetMessageIdTest extends JPushResponseTest
{

    /**
     * Unit test data provider.
     *
     * @return array $data array of endpoints statuses / status result
     */
    public function endpointDataProvider(): array
    {
        $data = [];

        // return NULL if endpoint not set
        $data[] = [ [], NULL ];

        // return NULL if endpoint absent
        $data[] = [
            [
                'endpoint1' => [
                    'status'     => PushNotificationStatus::INVALID_ENDPOINT,
                    'message_id' => '165468564'
                ],
            ],
            NULL,
        ];
        $data[] = [
            [
                'endpoint1' => [
                    'status'     => PushNotificationStatus::ERROR,
                    'message_id' => '165468564'
                ],
                'endpoint2' => [
                    'status'     => PushNotificationStatus::INVALID_ENDPOINT,
                    'message_id' => '165468564'
                ],
                'endpoint3' => [
                    'status'     => PushNotificationStatus::SUCCESS,
                    'message_id' => '555165655'
                ],
            ],
            NULL,
        ];

        // return NULL if batch was not set
        $data[] = [
            [
                'endpoint_param' => PushNotificationStatus::INVALID_ENDPOINT,
            ],
            NULL,
        ];
        $data[] = [
            [
                'endpoint_param' => [
                    'status' => PushNotificationStatus::INVALID_ENDPOINT,
                ],
            ],
            NULL,
        ];

        // return batch if batch is present
        $data[] = [
            [
                'endpoint_param' => [
                    'status'     => PushNotificationStatus::INVALID_ENDPOINT,
                    'message_id' => '165468564'
                ],
            ],
            '165468564',
        ];
        $data[] = [
            [
                'endpoint1'      => [
                    'status'     => PushNotificationStatus::ERROR,
                    'message_id' => '165468564'
                ],
                'endpoint_param' => [
                    'status'     => PushNotificationStatus::SUCCESS,
                    'message_id' => '165468564'
                ],
                'endpoint2'      => [
                    'status'     => PushNotificationStatus::INVALID_ENDPOINT,
                    'message_id' => '555165655'
                ],
            ],
            '165468564',
        ];

        return $data;
    }

    /**
     * Test the get_message_id() behavior.
     *
     * @param array $statuses Endpoints statuses
     * @param int   $batch    Expected function result
     *
     * @dataProvider endpointDataProvider
     * @covers       Lunr\Vortex\JPush\JPushResponse::get_message_id
     */
    public function testGetBatch($statuses, $batch): void
    {
        $this->set_reflection_property_value('statuses', $statuses);

        $result = $this->class->get_message_id('endpoint_param');

        $this->assertEquals($batch, $result);
    }

}

?>
