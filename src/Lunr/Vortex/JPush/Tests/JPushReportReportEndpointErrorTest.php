<?php

/**
 * This file contains the JPushReportReportEndpointErrorTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the get_report function of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportReportEndpointErrorTest extends JPushReportTest
{

    /**
     * Unit test data provider for endpoint errors.
     *
     * @return array Endpoint errors
     */
    public function endpointErrorProvider(): array
    {
        $return = [];

        $return['Unknown failure']                = [ 'endpoint1', 1, 0, 'Not delivered' ];
        $return['Registration ID unknown']        = [ 'endpoint2', 2, 3, 'Registration_id does not belong to the application' ];
        $return['Registration ID not in message'] = [ 'endpoint3', 3, 5, 'Registration_id belongs to the application, but it is not the target of the message' ];
        $return['System failure']                 = [ 'endpoint4', 4, 2, 'The system is abnormal' ];
        $return['Failure not matched']            = [ 'endpoint5', 5, 0, 5 ];

        return $return;
    }

    /**
     * Test the report_endpoint_error() succeeds.
     *
     * @param string $endpoint   Endpoint of the notification
     * @param int    $error_code Error response code
     * @param int    $status     Lunr status
     * @param string $message    Reported message
     *
     * @dataProvider endpointErrorProvider
     * @covers       \Lunr\Vortex\JPush\JPushReport::report_endpoint_error
     */
    public function testReportEndpointErrorSucceeds($endpoint, $error_code, $status, $message): void
    {
        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Dispatching push notification failed for endpoint {endpoint}: {error}', [ 'endpoint' => $endpoint,'error' => $message ]);

        $method = $this->get_accessible_reflection_method('report_endpoint_error');
        $method->invokeArgs($this->class, [ $endpoint, $error_code ]);

        $this->assertPropertyEquals('statuses', [ $endpoint => $status ]);
    }

}

?>
