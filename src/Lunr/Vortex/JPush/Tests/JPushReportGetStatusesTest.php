<?php

/**
 * This file contains the JPushReportGetStatusesTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Brian Stoop <brian.stoop@moveagency.com>
 * @copyright  2023, Move BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains test for the constructor of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportGetStatusesTest extends JPushReportTest
{

    /**
     * Test that get_statuses calls get report and returns statuses.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_statuses
     */
    public function testGetStatusesCallsGetReport(): void
    {
        $this->mock_method([ $this->class, 'get_report' ], function () { echo 'get_report'; });

        $this->set_reflection_property_value('statuses', []);

        $this->expectOutputString('get_report');

        $result = $this->class->get_statuses();

        $this->assertSame([], $result);

        $this->unmock_method([ $this->class, 'get_report' ]);
    }

    /**
     * Test that get_statuses does not call get_report but returns statuses
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::get_statuses
     */
    public function testGetStatusesDoesNotCallGetReportButReturnsStatuses(): void
    {
        $this->mock_method([ $this->class, 'get_report' ], function () { echo 'get_report'; });

        $this->set_reflection_property_value('statuses', [ 'endpoint1' => 1 ]);

        $this->expectOutputString('');

        $result = $this->class->get_statuses();

        $this->assertSame([ 'endpoint1' => 1 ], $result);

        $this->unmock_method([ $this->class, 'get_report' ]);
    }

}

?>
