<?php

/**
 * This file contains the FCMAndroidPayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\FCM\FCMAndroidPayload;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMAndroidPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMAndroidPayload
 */
abstract class FCMAndroidPayloadTest extends LunrBaseTest
{

    /**
     * Sample payload elements
     * @var array
     */
    protected $payload;

    /**
     * Instance of the tested class.
     * @var FCMAndroidPayload&MockObject&Stub
     */
    protected FCMAndroidPayload&MockObject&Stub $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->payload = [
            'notification' => [
                'title' => 'android_title',
                'body'  => 'android_body'
            ],
        ];

        $this->class = $this->getMockBuilder('Lunr\Vortex\FCM\FCMAndroidPayload')
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->payload);
        unset($this->class);

        parent::tearDown();
    }

}

?>
