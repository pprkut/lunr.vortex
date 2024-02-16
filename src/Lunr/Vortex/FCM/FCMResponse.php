<?php

/**
 * This file contains an abstraction for the response from the FCM server.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\PushNotificationResponseInterface;
use Lunr\Vortex\PushNotificationStatus;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Response;

/**
 * Firebase Cloud Messaging Push Notification response wrapper.
 */
class FCMResponse implements PushNotificationResponseInterface
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The response HTTP code.
     * @var int
     */
    private int $http_code;

    /**
     * The response body content.
     * @var string
     */
    private string $content;

    /**
     * Delivery status.
     * @var PushNotificationStatus
     */
    private PushNotificationStatus $status;

    /**
     * Push notification endpoint.
     * @var string
     */
    private string $endpoint;

    /**
     * Raw payload that was sent to FCM.
     * @var string
     */
    protected string $payload;

    /**
     * Constructor.
     *
     * @param Response        $response Requests\Response object.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     * @param string          $endpoint The endpoint the message was sent to.
     * @param string          $payload  Raw payload that was sent to FCM.
     */
    public function __construct(Response $response, LoggerInterface $logger, string $endpoint, string $payload)
    {
        $this->logger   = $logger;
        $this->payload  = $payload;
        $this->endpoint = $endpoint;

        $this->http_code = $response->status_code;
        $this->content   = $response->body;

        if ($this->http_code == 200)
        {
            $this->status = PushNotificationStatus::Success;
        }
        else
        {
            $this->report_error($endpoint);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->http_code);
        unset($this->content);
        unset($this->status);
        unset($this->payload);
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus Delivery status for the endpoint
     */
    public function get_status(string $endpoint): PushNotificationStatus
    {
        if ($endpoint != $this->endpoint)
        {
            return PushNotificationStatus::Unknown;
        }

        return $this->status;
    }

    /**
     * Report an error with the push notification.
     *
     * @param string $endpoint The endpoints the message was sent to.
     *
     * @return void
     */
    private function report_error(string $endpoint): void
    {
        $json_content = json_decode($this->content, TRUE);

        $error_message = $json_content['error']['message'] ?? NULL;
        $error_code    = $json_content['error']['details'][0]['errorCode'] ?? NULL;

        switch ($this->http_code)
        {
            case 400:
                $status          = PushNotificationStatus::Error;
                $error_message ??= 'Invalid parameter';
                break;
            case 401:
                $status          = PushNotificationStatus::Error;
                $error_message ??= 'Error with authentication';
                break;
            case 403:
                $status          = PushNotificationStatus::InvalidEndpoint;
                $error_message ??= 'Mismatched sender';
                break;
            case 404:
                $status          = PushNotificationStatus::InvalidEndpoint;
                $error_message ??= 'Unregisted or missing token';
                break;
            case 429:
                $status          = PushNotificationStatus::TemporaryError;
                $error_message ??= 'Exceeded qouta error';
                break;
            case 500:
                $status          = PushNotificationStatus::TemporaryError;
                $error_message ??= 'Internal error';
                break;
            case 503:
                $status          = PushNotificationStatus::TemporaryError;
                $error_message ??= 'Timeout';
                break;
            default:
                $status          = PushNotificationStatus::Unknown;
                $error_message ??= $error_code ?? 'Unknown error';
                break;
        }

        $context = [ 'endpoint' => $endpoint, 'error' => $error_message ];
        $this->logger->warning('Dispatching FCM notification failed for endpoint {endpoint}: {error}', $context);

        $this->status = $status;
    }

}

?>
