<?php

/**
 * This file contains the FCMResponseBasePushSuccessTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMResponse;
use Lunr\Vortex\PushNotificationStatus;
use ReflectionClass;

/**
 * This class contains tests for the constructor of the FCMResponse class
 * in case of a push notification success.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
class FCMResponseBasePushSuccessTest extends FCMResponseTest
{

    /**
     * Test constructor behavior for success of push notification with missing results.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushSuccessWithMissingResults(): void
    {
        $content  = file_get_contents(TEST_STATICS . '/Vortex/fcm/response_missing_results.json');
        $endpoint = 'endpoint1';

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => 'endpoint1', 'error' => 'Unknown error' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::Unknown);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushSuccessWithSingleSuccess(): void
    {
        $content  = file_get_contents(TEST_STATICS . '/Vortex/fcm/response_single_success.json');
        $endpoint = 'endpoint1';

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->logger->expects($this->never())
                     ->method('warning');

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::Success);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with single error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushSuccessWithSingleError(): void
    {
        $content  = file_get_contents(TEST_STATICS . '/Vortex/fcm/response_single_error.json');
        $endpoint = 'endpoint1';

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => 'endpoint1', 'error' => 'Invalid registration token' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::InvalidEndpoint);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Unit test data provider for external error codes.
     *
     * @return array $data http code
     */
    public function externalErrorCodeDataProvider()
    {
        $data = [];

        $data[] = [ 'Missing registration token', 'MissingRegistration', PushNotificationStatus::InvalidEndpoint ];
        $data[] = [ 'Invalid registration token', 'InvalidRegistration', PushNotificationStatus::InvalidEndpoint ];
        $data[] = [ 'Unregistered device', 'NotRegistered', PushNotificationStatus::InvalidEndpoint ];
        $data[] = [ 'Invalid package name', 'InvalidPackageName', PushNotificationStatus::InvalidEndpoint ];
        $data[] = [ 'Mismatched sender', 'MismatchSenderId', PushNotificationStatus::InvalidEndpoint ];
        $data[] = [ 'Message too big', 'MessageTooBig', PushNotificationStatus::Error ];
        $data[] = [ 'Invalid data key', 'InvalidDataKey', PushNotificationStatus::Error ];
        $data[] = [ 'Invalid time to live', 'InvalidTtl', PushNotificationStatus::Error ];
        $data[] = [ 'Timeout', 'Unavailable', PushNotificationStatus::TemporaryError ];
        $data[] = [ 'Internal server error', 'InternalServerError', PushNotificationStatus::TemporaryError ];
        $data[] = [ 'Device message rate exceeded', 'DeviceMessageRateExceeded', PushNotificationStatus::TemporaryError ];
        $data[] = [ 'Topics message rate exceeded', 'TopicsMessageRateExceeded', PushNotificationStatus::TemporaryError ];
        $data[] = [ 'unknown-stuff', 'unknown-stuff', PushNotificationStatus::Unknown ];

        return $data;
    }

    /**
     * Test constructor behavior for success of push notification with multiple errors.
     *
     * @param string                 $error_msg Error message we set
     * @param string                 $error     Error codes we recieve
     * @param PushNotificationStatus $status    The status code we map to the error
     *
     * @dataProvider externalErrorCodeDataProvider
     * @covers       Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushSuccessWithErrors(string $error_msg, string $error, PushNotificationStatus $status): void
    {
        $temp_content                        = json_decode(file_get_contents(TEST_STATICS . '/Vortex/fcm/response_single_error.json'), TRUE);
        $temp_content['results'][0]['error'] = $error;

        $content  = json_encode($temp_content);
        $endpoint = 'endpoint1';

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => $error_msg ]
                    );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', $status);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

}

?>
