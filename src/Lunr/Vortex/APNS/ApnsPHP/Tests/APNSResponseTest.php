<?php

/**
 * This file contains the APNSResponseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSResponse class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
abstract class APNSResponseTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var APNSResponse
     */
    protected APNSResponse $class;

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of an APNS Message class.
     * @var \ApnsPHP\Message
     */
    protected $apns_message;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->apns_message = $this->getMockBuilder('ApnsPHP\Message')
                                   ->disableOriginalConstructor()
                                   ->getMock();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->class);

        parent::tearDown();
    }

}

?>
