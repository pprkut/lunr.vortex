<?php

/**
 * This file contains the JPushReportTestCase class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTestCase;
use Lunr\Vortex\JPush\JPushReport;
use PHPUnit\Framework\MockObject\MockObject;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
abstract class JPushReportTestCase extends LunrBaseTestCase
{

    /**
     * Mock instance of the Requests\Session class.
     * @var Session&MockObject
     */
    protected $http;

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface|MockObject
     */
    protected $logger;

    /**
     * Mock instance of the Requests\Response class.
     * @var Response&MockObject
     */
    protected $response;

    /**
     * Instance of the tested class.
     * @var JPushReport
     */
    protected JPushReport $class;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->http = $this->getMockBuilder('WpOrg\Requests\Session')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $this->class = new JPushReport($this->http, $this->logger, 12, [ 'endpoint1' ]);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->http);
        unset($this->logger);
        unset($this->response);
        unset($this->class);

        parent::tearDown();
    }

}

?>
