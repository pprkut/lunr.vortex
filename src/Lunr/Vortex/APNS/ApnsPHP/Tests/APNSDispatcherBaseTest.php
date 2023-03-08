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
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
class APNSDispatcherBaseTest extends APNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the APNS message property is set to NULL.
     */
    public function testAPNSMessageIsNull(): void
    {
        $this->assertPropertyUnset('apns_message');
    }

    /**
     * Test that the APNS message function returns correctly.
     *
     * @covers \Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::get_new_apns_message
     */
    public function testNewAPNSMessage(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_apns_message');
        $result = $method->invokeArgs($this->class, []);

        $this->assertInstanceOf(Message::class, $result);
    }

}

?>
