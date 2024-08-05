<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use ApnsPHP\Message;
use ApnsPHP\Push;
use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\APNS\APNSPayload;
use Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use Psr\Log\LoggerInterface;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
abstract class APNSDispatcherTest extends LunrBaseTest
{

    /**
     * Instance of the tested class.
     * @var APNSDispatcher&MockObject&Stub
     */
    protected APNSDispatcher&MockObject&Stub $class;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of an APNS Push class.
     * @var Push
     */
    protected $apns_push;

    /**
     * Mock instance of an APNS Message class.
     * @var Message
     */
    protected $apns_message;

    /**
     * Mock instance of the APNS Payload class.
     * @var APNSPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->apns_push = $this->getMockBuilder('ApnsPHP\Push')
                                ->disableOriginalConstructor()
                                ->getMock();

        $this->apns_message = $this->getMockBuilder('ApnsPHP\Message')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\APNS\APNSPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher')
                            ->setConstructorArgs([ $this->logger, $this->apns_push ])
                            ->setMethods([ 'get_new_apns_message' ])
                            ->getMock();

        $this->class->expects($this->any())
                    ->method('get_new_apns_message')
                    ->willReturn($this->apns_message);

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->apns_push);
        unset($this->apns_message);
        unset($this->payload);
        unset($this->class);

        parent::tearDown();
    }

}

?>
