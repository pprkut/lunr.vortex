<?php

/**
 * This file contains the WNSBadgePayloadGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
class WNSBadgePayloadGetTest extends WNSBadgePayloadTest
{

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\WNS\WNSBadgePayload::get_payload
     */
    public function testGetPayload(): void
    {
        $file     = TEST_STATICS . '/Vortex/wns/badge.xml';
        $elements = [ 'value' => 2 ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
