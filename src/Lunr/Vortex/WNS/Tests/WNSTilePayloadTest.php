<?php

/**
 * This file contains the WNSTilePayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\WNS\WNSTilePayload;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
abstract class WNSTilePayloadTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var WNSTilePayload
     */
    protected WNSTilePayload $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->class = new WNSTilePayload();

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
