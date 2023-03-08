<?php

/**
 * This file contains the FCMBatchResponseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMBatchResponse class.
 *
 * @covers Lunr\Vortex\FCM\FCMBatchResponse
 */
abstract class FCMBatchResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests\Response class.
     * @var Response
     */
    protected $response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->response);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
