<?php

/**
 * This file contains the WNSTilePayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
class WNSTilePayloadBaseTest extends WNSTilePayloadTestCase
{

    /**
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitialized(): void
    {
        $elements = [
            'image'     => [],
            'templates' => [],
            'text'      => [],
        ];

        $this->assertPropertyEquals('elements', $elements);
    }

}

?>
