<?php

/**
 * This file contains the WNSDispatcherTest class.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSDispatcher;
use Lunr\Vortex\WNS\WNSType;
use Lunr\Halo\LunrBaseTest;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSDispatcher class.
 *
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
abstract class WNSDispatcherTest extends LunrBaseTest
{

    /**
     * Mock instance of the Requests\Session class.
     * @var Session
     */
    protected $http;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests\Response class.
     * @var Response
     */
    protected $response;

    /**
     * Mock instance of the WNS Payload class.
     * @var WNSPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->http = $this->getMockBuilder('WpOrg\Requests\Session')->getMock();

        $this->response = $this->getMockBuilder('WpOrg\Requests\Response')->getMock();

        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\WNS\WNSPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new WNSDispatcher($this->http, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->class);
        unset($this->reflection);
        unset($this->payload);
        unset($this->http);
        unset($this->logger);
        unset($this->response);
    }

    /**
     * Unit test data provider for valid WNS Types.
     *
     * @return array $types Array of WNS types.
     */
    public function validTypeProvider(): array
    {
        $types   = [];
        $types[] = [ WNSType::TILE ];
        $types[] = [ WNSType::TOAST ];
        $types[] = [ WNSType::RAW ];
        $types[] = [ WNSType::BADGE ];

        return $types;
    }

}

?>
