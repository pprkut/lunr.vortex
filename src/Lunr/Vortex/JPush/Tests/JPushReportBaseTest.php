<?php

/**
 * This file contains the JPushReportBaseTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Brian Stoop <brian.stoop@moveagency.com>
 * @copyright  2023, Move BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the JPushReport class.
 *
 * @covers \Lunr\Vortex\JPush\JPushReport
 */
class JPushReportBaseTest extends JPushReportTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requests_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that the auth token is set to an empty string by default.
     */
    public function testStatusesIsEmptyArray(): void
    {
        $this->assertPropertyEquals('statuses', []);
    }

    /**
     * Test auth_token is initialized as NULL.
     */
    public function testAuthTokenIsInitializedAsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('auth_token'));
    }

    /**
     * Test the set_auth_token() sets auth token.
     *
     * @covers \Lunr\Vortex\JPush\JPushReport::set_auth_token
     */
    public function testSetAuthTokenSetsAuthToken(): void
    {
        $this->class->set_auth_token('auth_token_24412');

        $this->assertPropertySame('auth_token', 'auth_token_24412');
    }

}

?>
