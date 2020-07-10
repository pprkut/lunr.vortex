<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

/**
 * This class contains tests for the push() method of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
class APNSDispatcherPushTest extends APNSDispatcherTest
{

    /**
     * Test that push() returns APNSResponseObject.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushReturnsAPNSResponseObject(): void
    {
        $endpoints = [];

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushResetsProperties(): void
    {
        $endpoints = [];

        $this->class->push($this->payload, $endpoints);

        $this->assertPropertyUnset('apns_message');
    }

    /**
     * Test that push() with a non JSON payload proceeds correctly without error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushWithNonJSONPayloadProceedsWithoutError(): void
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"yo"}');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() constructs the correct full payload.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushConstructsCorrectPayload(): void
    {
        $endpoints = [];

        $payload = [
            'title' => 'title',
            'body' => 'message',
            'thread_id' => '59ADAE4572BF42A682F46170DA5A74EC',
            'sound' => 'yo.mp3',
            'category' => 'messages_for_test',
            'mutable_content' => TRUE,
            'content_available' => TRUE,
            'yo' => 'he',
            'badge' => 7,
            'custom_data' => [
                'key1' => 'value1',
                'key2' => 'value2'
            ],
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn($payload);

        $i = -1;
        $this->apns_message->expects($this->at(++$i))
                           ->method('setTitle')
                           ->with($payload['title']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setText')
                           ->with($payload['body']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setThreadID')
                           ->with($payload['thread_id']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setSound')
                           ->with($payload['sound']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setCategory')
                           ->with($payload['category']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setBadge')
                           ->with($payload['badge']);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setContentAvailable')
                           ->with(TRUE);

        $this->apns_message->expects($this->at(++$i))
                           ->method('setMutableContent')
                           ->with(TRUE);

        $this->apns_message->expects($this->exactly(2))
                           ->method('setCustomProperty')
                           ->withConsecutive(
                               [ 'key1', 'value1' ],
                               [ 'key2', 'value2' ]
                           );

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() log payload building error with badge.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogPayloadBuildingBadgeError(): void
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn(['badge' => 'yo']);

        $this->apns_message->expects($this->once())
                           ->method('setBadge')
                           ->with('yo')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid badge: yo')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Invalid badge: yo');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log payload building error with custom property.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogPayloadBuildingCustomPropertyError(): void
    {
        $endpoints = [];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn(['custom_data' => ['apns' => 'value1']]);

        $this->apns_message->expects($this->once())
                           ->method('setCustomProperty')
                           ->with('apns', 'value1')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Reserved keyword: apns')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Reserved keyword: apns');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() add all endpoints to the message.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushAddAllEndpointsToMessage(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2' ];

        $this->apns_message->expects($this->exactly(2))
                           ->method('addRecipient')
                           ->withConsecutive([ 'endpoint1' ], [ 'endpoint2' ]);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() log invalid endpoints.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogInvalidEndpoints(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3' ];

        $pos = 0;

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint1')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid endpoint: endpoint1')));

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint2');

        $this->apns_message->expects($this->at($pos++))
                           ->method('addRecipient')
                           ->with('endpoint3')
                           ->will($this->throwException(new \ApnsPHP_Message_Exception('Invalid endpoint: endpoint3')));

        $this->logger->expects($this->exactly(2))
                     ->method('warning')
                     ->withConsecutive(
                        [ 'Invalid endpoint: endpoint1' ],
                        [ 'Invalid endpoint: endpoint3' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log failed connection.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogFailedConnection(): void
    {
        $endpoints = [];

        $this->apns_push->expects($this->once())
                        ->method('connect')
                        ->will($this->throwException(new \ApnsPHP_Exception('Failed to connect')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Failed to connect' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() log failed sending.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushLogFailedSending(): void
    {
        $endpoints = [];

        $this->apns_push->expects($this->once())
                        ->method('send')
                        ->will($this->throwException(new \ApnsPHP_Push_Exception('Failed to send')));

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Failed to send' ]
                     );

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

    /**
     * Test that push() send successfully.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::push
     */
    public function testPushSuccess(): void
    {
        $endpoints = [];

        $pos = 0;

        $this->apns_push->expects($this->at($pos++))
                        ->method('add')
                        ->with($this->apns_message);

        $this->apns_push->expects($this->at($pos++))
                        ->method('connect');

        $this->apns_push->expects($this->at($pos++))
                        ->method('send');

        $this->apns_push->expects($this->at($pos++))
                        ->method('disconnect');

        $error = [
            [
                'MESSAGE' => 'Error',
                'ERRORS'  => [],
            ],
        ];

        $this->apns_push->expects($this->at($pos++))
                        ->method('getErrors')
                        ->willReturn($error);

        $this->logger->expects($this->never())
                     ->method('warning');

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\APNS\ApnsPHP\APNSResponse', $result);
    }

}

?>
