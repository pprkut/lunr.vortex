<?php

/**
 * This file contains the JPushNotification3rdPayloadGetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the getters of the JPushNotification3rdPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload
 */
class JPushNotification3rdPayloadGetTest extends JPushNotification3rdPayloadTest
{

    /**
     * Test message get_payload() with everything being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::get_payload
     */
    public function testGetPayloadMessage(): void
    {
        $elements = [
            'registration_id' => [ 'one', 'two', 'three' ],
            'message'    => [
                'title' => 'title'
            ],
            'notification'    => [
                'android' => [
                    'alert' => 'a'
                ],
                'ios' => [
                    'alert' => 'a'
                ],
            ],
            'notification_3rd' => [
                'title' => 'title'
            ],
            'time_to_live'     => 10,
        ];
        $expected = [
            'registration_id' => [ 'one', 'two', 'three' ],
            'message'    => [
                'title' => 'title'
            ],
            'notification_3rd' => [
                'title' => 'title'
            ],
            'time_to_live'     => 10,
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertEquals($expected, $this->class->get_payload());
    }

}

?>
