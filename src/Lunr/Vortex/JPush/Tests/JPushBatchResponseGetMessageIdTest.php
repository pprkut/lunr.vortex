<?php

/**
 * This file contains the JPushBatchResponseGetMessageIdTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Brian Stoop <brian.stoop@moveagency.com>
 * @copyright  2023, Move BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the JPushBatchResponse class.
 *
 * @covers \Lunr\Vortex\JPush\JPushBatchResponse
 */
class JPushBatchResponseGetMessageIdTest extends JPushBatchResponseTest
{

    /**
     * Test get_message_id returns NULL when batch failed.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::get_message_id
     */
    public function testGetMessageIdWhenBatchFails(): void
    {
        $http_code = 400;
        $content   = '{"error": {"message": "Field \"collapse_key\" must be a JSON string: 1463565451"}}';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [], '[]');
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertNull($this->class->get_message_id());
    }

    /**
     * Test get_message_id returns message id when batch succeeds.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testGetMessageIdWhenBatchSucceeds(): void
    {
        $content = [ 'msg_id' => '121654513215' ];

        $this->response->success = TRUE;
        $this->response->body    = json_encode($content);

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [], '[]');
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertSame(121654513215, $this->class->get_message_id());
    }

}

?>
