<?php

/**
 * This file contains the FCMResponseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\FCM\FCMResponse;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMResponse class.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
abstract class FCMResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the FCMBatchResponse class.
     * @var Lunr\Vortex\FCM\FCMBatchResponse
     */
    protected $batch_response;

    /**
     * Instance of the tested class.
     * @var FCMResponse
     */
    protected FCMResponse $class;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->batch_response = $this->getMockBuilder('Lunr\Vortex\FCM\FCMBatchResponse')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new FCMResponse();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->batch_response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
