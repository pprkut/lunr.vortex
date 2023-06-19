<?php

/**
 * This file contains the JPushReportGetReportTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Exception\Http\Status400 as RequestsExceptionHTTP400;

/**
 * This class contains tests for the get_report function of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportGetReportTest extends JPushReportTest
{

    /**
     * Test the get_report() returns when http request fails
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_report
     */
    public function testGetReportReturnsWhenHttpRequestFails(): void
    {
        $this->mock_method([ $this->class, 'report_error' ], function ($response) { echo $response->status_code; });

        $this->response->status_code = 400;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1"]}', [])
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new RequestsExceptionHTTP400(NULL, NULL));

        $this->expectOutputString('400');

        $this->class->get_report(1453658564165, [ 'endpoint1' ]);

        $this->assertPropertyEquals('statuses', []);

        $this->unmock_method([ $this->class, 'report_error' ]);
    }

    /**
     * Test get_report() when the curl request fails.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_report
     */
    public function testGetReportWithCurlErrors(): void
    {
        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1"]}', [])
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new RequestsException('cURL error 0001: Network error', 'curlerror', NULL));

        $context = [
            'error' => 'cURL error 0001: Network error',
        ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Getting JPush notification report failed: {error}', $context);

        $this->class->get_report(1453658564165, [ 'endpoint1' ]);

        $this->assertPropertyEquals('statuses', [ 'endpoint1' => 5 ]);
    }

    /**
     * Test the get_report() behavior to fetch new statuses.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_report
     */
    public function testGetReportWillFetchUpstreamMixedErrorSuccess(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5', 'endpoint6', 'endpoint7' ];

        $report_content          = '{"endpoint1": {"status":1},"endpoint2": {"status":2},"endpoint3": {"status":3},"endpoint4": {"status":4},"endpoint5": {"status":5},"endpoint6": {"status":6},"endpoint7": {"status":0}}';
        $this->response->success = TRUE;
        $this->response->body    = $report_content;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1","endpoint2","endpoint3","endpoint4","endpoint5","endpoint6","endpoint7"]}', [])
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $log_message = 'Dispatching push notification failed for endpoint {endpoint}: {error}';
        $this->logger->expects($this->exactly(6))
                     ->method('warning')
                     ->withConsecutive(
                         [ $log_message, [ 'endpoint' => 'endpoint1','error' => 'Not delivered' ]],
                         [ $log_message, [ 'endpoint' => 'endpoint2','error' => 'Registration_id does not belong to the application' ]],
                         [ $log_message, [ 'endpoint' => 'endpoint3','error' => 'Registration_id belongs to the application, but it is not the target of the message' ]],
                         [ $log_message, [ 'endpoint' => 'endpoint4','error' => 'The system is abnormal' ]],
                         [ $log_message, [ 'endpoint' => 'endpoint5','error' => 5 ]],
                         [ $log_message, [ 'endpoint' => 'endpoint6','error' => 6 ]]
                     );

        $this->class->get_report(1453658564165, $endpoints);

        $this->assertPropertyEquals('statuses', [
            'endpoint1' => 0,
            'endpoint2' => 3,
            'endpoint3' => 5,
            'endpoint4' => 2,
            'endpoint5' => 0,
            'endpoint6' => 0,
            'endpoint7' => 1,
        ]);
    }

}

?>
