<?php

/**
 * This file contains functionality to dispatch Firebase Cloud Messaging Push Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use Lunr\Vortex\PushNotificationResponseInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use InvalidArgumentException;

/**
 * Firebase Cloud Messaging Push Notification Dispatcher.
 */
class FCMDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Maximum number of endpoints allowed in one push.
     * @var integer
     */
    private const BATCH_SIZE = 1000;

    /**
     * Push Notification authentication token.
     * @var string
     */
    protected string $auth_token;

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
     * Url to send the FCM push notification to.
     * @var string
     */
    private const GOOGLE_SEND_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Service name.
     * @var string
     */
    private const SERVICE_NAME = 'FCM';

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
        $this->auth_token = '';
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
     * Getter for FCMResponse.
     *
     * @return FCMResponse
     */
    public function get_response(): FCMResponse
    {
        return new FCMResponse();
    }

    /**
     * Getter for FCMBatchResponse.
     *
     * @param Response        $http_response Requests\Response object.
     * @param LoggerInterface $logger        Shared instance of a Logger.
     * @param array           $endpoints     The endpoints the message was sent to (in the same order as sent).
     * @param string          $payload       Raw payload that was sent to FCM.
     *
     * @return FCMBatchResponse
     */
    public function get_batch_response(Response $http_response, LoggerInterface $logger, array $endpoints, string $payload): FCMBatchResponse
    {
        return new FCMBatchResponse($http_response, $logger, $endpoints, $payload);
    }

    /**
     * Push the notification.
     *
     * @param object $payload   Payload object
     * @param array  $endpoints Endpoints to send to in this batch
     *
     * @return FCMResponse Response object
     */
    public function push(object $payload, array &$endpoints): FCMResponse
    {
        if (!$payload instanceof FCMPayload)
        {
            throw new InvalidArgumentException('Invalid payload object!');
        }

        $fcm_response = $this->get_response();

        foreach (array_chunk($endpoints, self::BATCH_SIZE) as &$batch)
        {
            $batch_response = $this->push_batch($payload, $batch);

            $fcm_response->add_batch_response($batch_response, $batch);

            unset($batch_response);
        }

        unset($batch);

        return $fcm_response;
    }

    /**
     * Push the notification to a batch of endpoints.
     *
     * @param FCMPayload $payload   Payload object
     * @param array      $endpoints Endpoints to send to in this batch
     *
     * @return FCMBatchResponse Response object
     */
    protected function push_batch(FCMPayload $payload, array &$endpoints)
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=' . $this->auth_token,
        ];

        $tmp_payload = json_decode($payload->get_payload(), TRUE);

        if (count($endpoints) > 1)
        {
            $tmp_payload['registration_ids'] = $endpoints;
        }
        elseif (isset($endpoints[0]))
        {
            $tmp_payload['to'] = $endpoints[0];
        }

        $json_payload = json_encode($tmp_payload, JSON_UNESCAPED_UNICODE);

        try
        {
            $options = [
                'timeout'         => 15, // timeout in seconds
                'connect_timeout' => 15 // timeout in seconds
            ];

            $http_response = $this->http->post(self::GOOGLE_SEND_URL, $headers, $json_payload, $options);
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

        return $this->get_batch_response($http_response, $this->logger, $endpoints, $json_payload);
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the fcm push notifications
     *
     * @return FCMDispatcher Self reference
     */
    public function set_auth_token(string $auth_token): self
    {
        $this->auth_token = $auth_token;

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

        $http_response->url = self::GOOGLE_SEND_URL;

        return $http_response;
    }

}

?>
