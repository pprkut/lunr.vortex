<?php

/**
 * This file contains the WNSDispatcherBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSType;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the WNSDispatcher class.
 *
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
class WNSDispatcherBaseTest extends WNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requesys_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertSame($this->http, $this->get_reflection_property_value('http'));
    }

    /**
     * Test that the type is set to RAW by default.
     */
    public function testTypeIsSetToRaw(): void
    {
        $this->assertSame(WNSType::RAW, $this->get_reflection_property_value('type'));
    }

    /**
     * Test get_new_response_object_for_failed_request().
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_new_response_object_for_failed_request
     */
    public function testGetNewResponseObjectForFailedRequest(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_response_object_for_failed_request');

        $result = $method->invokeArgs($this->class, [ 'http://localhost/' ]);

        $this->assertInstanceOf('WpOrg\Requests\Response', $result);
        $this->assertEquals('http://localhost/', $result->url);
    }

}

?>
