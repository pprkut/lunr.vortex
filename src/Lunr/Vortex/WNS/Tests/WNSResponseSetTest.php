<?php

/**
 * This file contains the WNSResponseSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\WNS\WNSResponse;

/**
 * This class contains tests for setting meta information about WNS dispatches.
 *
 * @covers Lunr\Vortex\WNS\WNSResponse
 */
class WNSResponseSetTest extends WNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpSuccess();
    }

    /**
     * Test setting the status for a successful request.
     *
     * @covers Lunr\Vortex\WNS\WNSResponse::set_status
     */
    public function testStatusForSuccessRequestStatus(): void
    {
        $response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $response->headers = [
            'Date'                         => '2016-01-13',
            'X-WNS-Status'                 => 'received',
            'X-WNS-DeviceConnectionStatus' => 'N/A',
        ];

        $response->status_code = 200;
        $response->url         = 'http://localhost/';

        $class = new WNSResponse($response, $this->logger, '<?xml version="1.0" encoding="utf-8"?>');

        $value = $this->get_reflection_property('status')
                      ->getValue($class);

        $this->assertEquals(PushNotificationStatus::Success, $value);
    }

    /**
     * Test setting the status for a failed request.
     *
     * @param int    $code     Status code
     * @param string $nstatus  Notification status string
     * @param int    $expected Expected push notification status
     *
     * @dataProvider failedRequestProvider
     * @covers       Lunr\Vortex\WNS\WNSResponse::set_status
     */
    public function testSetStatusForNonSuccessRequestStatus($code, $nstatus, $expected): void
    {
        $response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $response->headers = [
            'Date'                         => '2016-01-13',
            'X-WNS-Status'                 => $nstatus,
            'X-WNS-DeviceConnectionStatus' => 'N/A',
            'X-WNS-Error-Description'      => 'Something is broken',
            'X-WNS-Debug-Trace'            => 'Tracing brokenness',
        ];

        $response->status_code = $code;
        $response->url         = 'http://localhost/';

        $context = [
            'endpoint'          => 'http://localhost/',
            'nstatus'           => $nstatus,
            'dstatus'           => 'N/A',
            'error_description' => 'Something is broken',
            'error_trace'       => 'Tracing brokenness',
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= '{nstatus}, device {dstatus}, description {error_description}, trace {error_trace}';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         $this->equalTo($message),
                         $this->equalTo($context)
                     );

        $class = new WNSResponse($response, $this->logger, '<?xml version="1.0" encoding="utf-8"?>');

        $value = $this->get_reflection_property('status')
                      ->getValue($class);

        $this->assertEquals($expected, $value);
    }

}

?>
