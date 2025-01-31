<?php

/**
 * This file contains the JPushMessagePayloadGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the getters of the JPushMessagePayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushMessagePayload
 */
class JPushMessagePayloadGetTest extends JPushMessagePayloadTestCase
{

    /**
     * Test message get_payload() with everything being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushMessagePayload::get_payload
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
            'time_to_live'     => 10,
        ];

        $this->setReflectionPropertyValue('elements', $elements);

        $this->assertEquals($expected, $this->class->get_payload());
    }

}

?>
