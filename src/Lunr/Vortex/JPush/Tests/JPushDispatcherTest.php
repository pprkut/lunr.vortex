<?php

/**
 * This file contains the JPushDispatcherTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushDispatcher;
use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushPayload;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushDispatcher class.
 *
 * @covers \Lunr\Vortex\JPush\JPushDispatcher
 */
abstract class JPushDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the Requests\Session class.
     * @var Session
     */
    protected $http;
    /**
     * Mock instance of the Requests\Response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the JPush Payload class.
     * @var JPushPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->http     = $this->getMockBuilder('WpOrg\Requests\Session')->getMock();
        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $this->payload  = $this->getMockBuilder('Lunr\Vortex\JPush\JPushPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new JPushDispatcher($this->http, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->http);
        unset($this->response);
        unset($this->logger);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
