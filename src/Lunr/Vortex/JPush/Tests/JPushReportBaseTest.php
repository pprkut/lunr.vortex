<?php

/**
 * This file contains the JPushReportBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportBaseTest extends JPushReportTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requests\Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that the auth token is set to an empty string by default.
     */
    public function testStatusesIsEmptyArray(): void
    {
        $this->assertPropertyEquals('statuses', []);
    }

}

?>
