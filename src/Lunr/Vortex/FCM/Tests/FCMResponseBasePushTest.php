<?php

/**
 * This file contains the FCMResponseBasePushTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMResponse;
use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the constructor of the FCMResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
class FCMResponseBasePushTest extends FCMResponseTest
{

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushSuccesWithSingleSuccess(): void
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
     * Test constructor behavior for error of push notification in case of bad request error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorBadRequestError(): void
    {
        $http_code = 400;
        $content   = file_get_contents(TEST_STATICS . '/Vortex/fcm/response_single_error.json');
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'The registration token is not a valid FCM registration token' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::Error);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of authentication error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorAuthenticationError(): void
    {
        $http_code = 401;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Error with authentication' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::Error);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of mis matched sender error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorMisMatchedSenderError(): void
    {
        $http_code = 403;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Mismatched sender' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::InvalidEndpoint);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of unregistered error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorUnregisteredError(): void
    {
        $http_code = 404;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Unregisted or missing token' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::InvalidEndpoint);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of exceeded qouta error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorExceededQuotaError(): void
    {
        $http_code = 429;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Exceeded qouta error' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::TemporaryError);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of internal error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorInternalError(): void
    {
        $http_code = 500;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Internal error' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::TemporaryError);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of timeout error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorTimeOutError(): void
    {
        $http_code = 503;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Timeout' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::TemporaryError);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of unknown error.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::__construct
     */
    public function testPushErrorUnknownError(): void
    {
        $http_code = 440;
        $content   = 'stuff';
        $endpoint  = 'endpoint1';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                         [ 'endpoint' => $endpoint, 'error' => 'Unknown error' ]
                     );

        $this->class = new FCMResponse($this->response, $this->logger, $endpoint, '{}');

        parent::baseSetUp($this->class);

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertySame('endpoint', $endpoint);
        $this->assertPropertyEquals('status', PushNotificationStatus::Unknown);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

}

?>
