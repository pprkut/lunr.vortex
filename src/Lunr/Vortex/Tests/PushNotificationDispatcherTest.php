<?php

/**
 * This file contains the PushNotificationDispatcherTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Tests;

use Lunr\Vortex\PushNotificationDispatcher;
use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher;
use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;
use Lunr\Vortex\Email\EmailDispatcher;
use Lunr\Vortex\Email\EmailResponse;
use Lunr\Vortex\FCM\FCMDispatcher;
use Lunr\Vortex\FCM\FCMResponse;
use Lunr\Vortex\JPush\JPushDispatcher;
use Lunr\Vortex\JPush\JPushResponse;
use Lunr\Vortex\WNS\WNSDispatcher;
use Lunr\Vortex\WNS\WNSResponse;
use Lunr\Vortex\PushNotificationStatus;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PushNotificationDispatcher class.
 *
 * @covers PushNotificationDispatcher
 */
abstract class PushNotificationDispatcherTest extends LunrBaseTest
{

    /**
     * Mock instance of the APNSDispatcher class
     * @var APNSDispatcher&MockObject&Stub
     */
    protected APNSDispatcher&MockObject&Stub $apns;

    /**
     * Mock instance of the EmailDispatcher class
     * @var EmailDispatcher&MockObject&Stub
     */
    protected EmailDispatcher&MockObject&Stub $email;

    /**
     * Mock instance of the FCMDispatcher class
     * @var FCMDispatcher&MockObject&Stub
     */
    protected FCMDispatcher&MockObject&Stub $fcm;

    /**
     * Mock instance of the WNSDispatcher class
     * @var WNSDispatcher&MockObject&Stub
     */
    protected WNSDispatcher&MockObject&Stub $wns;

    /**
     * Mock instance of the JPushDispatcher class
     * @var JPushDispatcher&MockObject&Stub
     */
    protected JPushDispatcher&MockObject&Stub $jpush;

    /**
     * Mock instance of the APNSResponse class
     * @var APNSResponse&MockObject&Stub
     */
    protected APNSResponse&MockObject&Stub $apns_response;

    /**
     * Mock instance of the FCMResponse class
     * @var FCMResponse&MockObject&Stub
     */
    protected FCMResponse&MockObject&Stub $fcm_response;

    /**
     * Mock instance of the EmailResponse class
     * @var EmailResponse&MockObject&Stub
     */
    protected EmailResponse&MockObject&Stub $email_response;

    /**
     * Mock instance of the WNSResponse class
     * @var WNSResponse&MockObject&Stub
     */
    protected WNSResponse&MockObject&Stub $wns_response;

    /**
     * Mock instance of the JPushResponse class
     * @var JPushResponse&MockObject&Stub
     */
    protected JPushResponse&MockObject&Stub $jpush_response;

    /**
     * Instance of the tested class.
     * @var PushNotificationDispatcher
     */
    protected PushNotificationDispatcher $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->apns = $this->getMockBuilder(APNSDispatcher::class)
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->email = $this->getMockBuilder(EmailDispatcher::class)
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->fcm = $this->getMockBuilder(FCMDispatcher::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $this->wns = $this->getMockBuilder(WNSDispatcher::class)
                          ->disableOriginalConstructor()
                          ->getMock();

        $this->jpush = $this->getMockBuilder(JPushDispatcher::class)
                            ->disableOriginalConstructor()
                            ->getMock();

        $this->apns_response = $this->getMockBuilder(APNSResponse::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        $this->fcm_response = $this->getMockBuilder(FCMResponse::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->email_response = $this->getMockBuilder(EmailResponse::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->wns_response = $this->getMockBuilder(WNSResponse::class)
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->jpush_response = $this->getMockBuilder(JPushResponse::class)
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new PushNotificationDispatcher();

        $this->baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->apns);
        unset($this->email);
        unset($this->fcm);
        unset($this->wns);
        unset($this->jpush);
        unset($this->apns_response);
        unset($this->email_response);
        unset($this->fcm_response);
        unset($this->wns_response);
        unset($this->jpush_response);
        unset($this->class);

        parent::tearDown();
    }

    /**
     * Unit test data provider for push notification status codes.
     *
     * @return array Array of status codes and expected status keys
     */
    public function statusCodesProvider(): array
    {
        $values   = [];
        $values[] = [ PushNotificationStatus::Unknown ];
        $values[] = [ PushNotificationStatus::Success ];
        $values[] = [ PushNotificationStatus::Error ];
        $values[] = [ PushNotificationStatus::InvalidEndpoint ];
        $values[] = [ PushNotificationStatus::TemporaryError ];
        $values[] = [ PushNotificationStatus::ClientError ];

        return $values;
    }

}

?>
