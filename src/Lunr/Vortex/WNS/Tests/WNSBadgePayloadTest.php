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

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
abstract class WNSBadgePayloadTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var WNSBadgePayload
     */
    protected WNSBadgePayload $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new WNSBadgePayload();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);

        parent::tearDown();
    }

}

?>
