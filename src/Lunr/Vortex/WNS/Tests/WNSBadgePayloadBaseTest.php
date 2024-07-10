<?php

/**
 * This file contains the WNSBadgePayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
class WNSBadgePayloadBaseTest extends WNSBadgePayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('elements'));
    }

}

?>
