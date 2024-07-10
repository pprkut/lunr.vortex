<?php

/**
 * This file contains the WNSToastPayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSToastPayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSToastPayload
 */
class WNSToastPayloadBaseTest extends WNSToastPayloadTest
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitialized(): void
    {
        $elements = [
            'text' => [],
        ];

        $this->assertPropertyEquals('elements', $elements);
    }

}

?>
