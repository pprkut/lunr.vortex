<?php

/**
 * This file contains the JPushResponseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushResponse;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushResponse class.
 *
 * @covers Lunr\Vortex\JPush\JPushResponse
 */
abstract class JPushResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the JPushBatchResponse class.
     * @var Lunr\Vortex\JPush\JPushBatchResponse
     */
    protected $batch_response;

    /**
     * Instance of the tested class.
     * @var JPushResponse
     */
    protected JPushResponse $class;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->batch_response = $this->getMockBuilder('Lunr\Vortex\JPush\JPushBatchResponse')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new JPushResponse();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->batch_response);
        unset($this->class);

        parent::tearDown();
    }

}

?>
