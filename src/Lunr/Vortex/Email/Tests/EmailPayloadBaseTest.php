<?php

/**
 * This file contains the EmailPayloadBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains the Base tests of the EmailPayload class.
 *
 * @covers Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadBaseTest extends EmailPayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray(): void
    {
        $expected = [
            'charset'  => 'UTF-8',
            'encoding' => 'base64',
            'subject'  => '',
            'body'     => '',
        ];

        $this->assertEquals($expected, $this->get_reflection_property_value('elements'));
    }

}

?>
