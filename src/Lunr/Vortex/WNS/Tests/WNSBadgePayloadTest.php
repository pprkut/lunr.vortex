<?php

/**
 * This file contains the WNSBadgePayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSBadgePayload;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
abstract class WNSBadgePayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new WNSBadgePayload();

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSBadgePayload');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
    }

}

?>
