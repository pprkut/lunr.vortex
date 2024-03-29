<?php

/**
 * This file contains the FCMApnsPayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\FCM\FCMApnsPayload;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the FCMApnsPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMApnsPayload
 */
class FCMApnsPayloadTest extends LunrBaseTest
{

    /**
     * Sample payload elements
     * @var array
     */
    protected $payload;

    /**
     * Instance of the tested class.
     * @var FCMApnsPayload&MockObject&Stub
     */
    protected FCMApnsPayload&MockObject&Stub $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->payload = [
            'notification' => [
                'title' => 'apns_title',
                'body'  => 'apns_body'
            ],
        ];

        $this->class = $this->getMockBuilder('Lunr\Vortex\FCM\FCMApnsPayload')
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
