<?php

/**
 * This file contains an abstraction for the response from the FCM server.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

use InvalidArgumentException;
use Lunr\Vortex\PushNotificationResponseInterface;
use Lunr\Vortex\PushNotificationStatus;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Response;

/**
 * Firebase Cloud Messaging Push Notification response wrapper.
 */
class FCMBatchResponse implements PushNotificationResponseInterface
{
    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The responses.
     * @var array<string,Response|RequestsException>|array{0:Response}
     */
    private array $responses;

    /**
     * The statuses per endpoint.
     * @var array<string,PushNotificationStatus>
     */
    protected array $statuses;

    /**
     * Push notification endpoints.
     * @var string[]
     */
    private array $endpoints;

    /**
     * Constructor.
     *
     * @param array<string,Response|RequestsException>|array{0:Response} $responses Array of Requests\Response object.
     * @param LoggerInterface                                            $logger    Shared instance of a Logger.
     * @param string[]                                                   $endpoints The endpoint the message was sent to.
     */
    public function __construct(array $responses, LoggerInterface $logger, array $endpoints)
    {
        $this->logger    = $logger;
        $this->endpoints = $endpoints;
        $this->responses = $responses;

        if (array_is_list($responses) && count($responses) === 1)
        {
            foreach ($endpoints as $endpoint)
            {
                $this->report_endpoint_error($endpoint, $responses[0]);
            }
        }
        else
        {
            $this->set_statuses();
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->responses);
        unset($this->statuses);
        unset($this->endpoints);
    }

    /**
     * Set endpoint statusses
     *
     * @return void
     */
    private function set_statuses(): void
    {
        foreach ($this->endpoints as $endpoint)
        {
            $response = $this->responses[$endpoint];

            if ($response instanceof RequestsException)
            {
                $this->logger->warning(
                    'Dispatching FCM notification failed for endpoint {endpoint}: {error}',
                    [ 'endpoint' => $endpoint, 'error' => $response->getMessage() ]
                );

                if ($response->getType() == 'curlerror' && curl_errno($response->getData()) == 28)
                {
                    $this->statuses[$endpoint] = PushNotificationStatus::TemporaryError;
                    continue;
                }

                $this->statuses[$endpoint] = PushNotificationStatus::Unknown;
                continue;
            }

            if ($response->status_code === 200)
            {
                $this->statuses[$endpoint] = PushNotificationStatus::Success;

                continue;
            }

            $this->report_endpoint_error($endpoint, $response);
        }
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
        if (!in_array($endpoint, $this->endpoints))
        {
            throw new InvalidArgumentException('Invalid endpoint: Endpoint was not part of this batch!');
        }

        return $this->statuses[$endpoint] ?? PushNotificationStatus::Unknown;
    }

    /**
     * Report an error with the push notification for one endpoint.
     *
     * @param string   $endpoint Endpoint.
     * @param Response $response The response of the push request.
     *
     * @return void
     */
    private function report_endpoint_error(string $endpoint, Response $response): void
    {
        $json_content = json_decode($response->body, TRUE);

        $error_message = $json_content['error']['message'] ?? NULL;
        $error_code    = $json_content['error']['details'][0]['errorCode'] ?? NULL;

        switch ($response->status_code)
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

        $this->statuses[$endpoint] = $status;
    }

}

?>
