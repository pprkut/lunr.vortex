<?php

/**
 * This file contains the EmailDispatcherTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\Email\EmailDispatcher;
use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\Email\EmailPayload;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
abstract class EmailDispatcherTest extends LunrBaseTest
{

    /**
     * Mock instance of the PHPMailer class.
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    protected $mail_transport;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Email Payload class.
     * @var EmailPayload
     */
    protected $payload;

    /**
     * Instance of the tested class.
     * @var EmailDispatcher
     */
    protected EmailDispatcher $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->mail_transport = $this->getMockBuilder('PHPMailer\PHPMailer\PHPMailer')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\Email\EmailPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new EmailDispatcher($this->mail_transport, $this->logger);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->mail_transport);
        unset($this->payload);
        unset($this->class);

        parent::tearDown();
    }

}

?>
