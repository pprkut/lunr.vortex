<?php

/**
 * This file contains the JPushReportTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Brian Stoop <brian.stoop@moveagency.com>
 * @copyright  2023, Move BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushReport;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
abstract class JPushReportTest extends LunrBaseTest
{

    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session|MockObject
     */
    protected $http;

    /**
     * Mock instance of the Logger class.
     * @var \Psr\Log\LoggerInterface|MockObject
     */
    protected $logger;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response|MockObject
     */
    protected $response;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->http = $this->getMockBuilder('Requests_Session')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->class      = new JPushReport($this->http, $this->logger, 12, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushReport');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->http);
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
