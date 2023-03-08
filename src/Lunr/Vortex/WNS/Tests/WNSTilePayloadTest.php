<?php

/**
 * This file contains the WNSTilePayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSTilePayload;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
abstract class WNSTilePayloadTest extends LunrBaseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new WNSTilePayload();

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSTilePayload');
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
