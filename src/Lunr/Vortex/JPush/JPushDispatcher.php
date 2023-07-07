<?php

/**
 * This file contains functionality to dispatch JPush Push Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use Lunr\Vortex\PushNotificationResponseInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use InvalidArgumentException;

/**
 * JPush Push Notification Dispatcher.
 */
class JPushDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Maximum number of endpoints allowed in one push.
     * @var integer
     */
    private const BATCH_SIZE = 1000;

    /**
     * Url to send the JPush push notification to.
     * @var string
     */
    private const JPUSH_SEND_URL = 'https://api.jpush.cn/v3/push';

    /**
     * Service name.
     * @var string
     */
    private const SERVICE_NAME = 'JPush';

    /**
     * Push Notification authentication token.
     * @var string|null
     */
    protected ?string $auth_token;

    /**
     * Shared instance of the Requests\Session class.
     * @var Session
     */
    protected Session $http;

    /**
     * Shared instance of a Logger class.
     *
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param Session         $http   Shared instance of the Requests\Session class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct(Session $http, LoggerInterface $logger)
    {
        $this->http       = $http;
        $this->logger     = $logger;
        $this->auth_token = NULL;

        $this->http->options = [
            'timeout'         => 15, // timeout in seconds
            'connect_timeout' => 15 // timeout in seconds
        ];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->auth_token);
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Getter for JPushResponse.
     *
     * @return JPushResponse
     */
    public function get_response(): JPushResponse
    {
        return new JPushResponse();
    }

    /**
     * Getter for JPushBatchResponse.
     *
     * @param Response $http_response Requests\Response object.
     * @param string[] $endpoints     The endpoints the message was sent to (in the same order as sent).
     * @param string   $payload       Raw payload that was sent to JPush.
     *
     * @return JPushBatchResponse
     */
    public function get_batch_response(Response $http_response, array $endpoints, string $payload): JPushBatchResponse
    {
        return new JPushBatchResponse($this->http, $this->logger, $http_response, $endpoints, $payload);
    }

    /**
     * Push the notification.
     *
     * @param object   $payload   Payload object
     * @param string[] $endpoints Endpoints to send to in this batch
     *
     * @return JPushResponse Response object
     */
    public function push(object $payload, array &$endpoints): JPushResponse
    {
        if (!$payload instanceof JPushPayload)
        {
            throw new InvalidArgumentException('Invalid payload object!');
        }

        $response = $this->get_response();

        foreach (array_chunk($endpoints, self::BATCH_SIZE) as &$batch)
        {
            $batch_response = $this->push_batch($payload, $batch);

            $response->add_batch_response($batch_response, $batch);

            unset($batch_response);
        }

        unset($batch);

        return $response;
    }

    /**
     * Push the notification to a batch of endpoints.
     *
     * @param JPushPayload $payload   Payload object
     * @param string[]     $endpoints Endpoints to send to in this batch
     *
     * @return JPushBatchResponse Response object
     */
    protected function push_batch(JPushPayload $payload, array &$endpoints): JPushBatchResponse
    {

        $tmp_payload                                = $payload->get_payload();
        $tmp_payload['audience']['registration_id'] = $endpoints;

        $json_payload = json_encode($tmp_payload, JSON_UNESCAPED_UNICODE);

        try
        {
            $http_response = $this->http->post(self::JPUSH_SEND_URL, [], $json_payload, []);
        }
        catch (RequestsException $e)
        {
            $this->logger->warning(
                'Dispatching ' . self::SERVICE_NAME . ' notification(s) failed: {message}',
                [ 'message' => $e->getMessage() ]
            );
            $http_response = $this->get_new_response_object_for_failed_request();

            if ($e->getType() == 'curlerror' && curl_errno($e->getData()) == 28)
            {
                $http_response->status_code = 500;
            }
        }

        return $this->get_batch_response($http_response, $endpoints, $json_payload);
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the JPush push notifications
     *
     * @return JPushDispatcher Self reference
     */
    public function set_auth_token(string $auth_token): self
    {
        $this->auth_token = $auth_token;

        $this->http->headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . $this->auth_token,
        ];

        return $this;
    }

    /**
     * Get a Requests\Response object for a failed request.
     *
     * @return Response New instance of a Requests\Response object.
     */
    protected function get_new_response_object_for_failed_request(): Response
    {
        $http_response = new Response();

        $http_response->url = self::JPUSH_SEND_URL;

        return $http_response;
    }

}

?>
