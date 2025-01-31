<?php

/**
 * This file contains the EmailPayloadGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the getters of the EmailPayload class.
 *
 * @covers Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadGetTest extends EmailPayloadTestCase
{

    /**
     * Test get_payload() with the message being present.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::get_payload
     */
    public function testGetPayload(): void
    {
        $payload  = json_decode(file_get_contents(TEST_STATICS . '/Vortex/email/payload.json'), TRUE);
        $elements = [
            'subject'  => 'value1',
            'body'     => 'value2',
            'charset'  => 'UTF-8',
            'encoding' => 'base64',
        ];

        $this->setReflectionPropertyValue('elements', $elements);

        $this->assertSame($payload, $this->class->get_payload());
    }

}

?>
