<?php

/**
 * This file contains an abstraction for the response from the WNS server.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS;

use Lunr\Vortex\PushNotificationResponseInterface;
use Lunr\Vortex\PushNotificationStatus;
use WpOrg\Requests\Response;
use WpOrg\Requests\Response\Headers;
use Psr\Log\LoggerInterface;

/**
 * Windows Push Notification response wrapper.
 */
class WNSResponse implements PushNotificationResponseInterface
{

    /**
     * HTTP headers of the response.
     * @var Headers
     */
    private $headers;

    /**
     * HTTP status code.
     * @var mixed
     */
    private $http_code;

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
     * Raw payload that was sent to WNS.
     * @var string|null
     */
    protected ?string $payload;

    /**
     * Constructor.
     *
     * @param Response        $response Requests\Response object.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     * @param string|null     $payload  Raw payload that was sent to WNS.
     */
    public function __construct(Response $response, LoggerInterface $logger, ?string $payload)
    {
        $this->http_code = $response->status_code;
        $this->endpoint  = $response->url;
        $this->payload   = $payload;

        if ($this->http_code === FALSE)
        {
            $this->status = PushNotificationStatus::Error;
        }
        else
        {
            $this->headers = $response->headers;
            $this->set_status($response->url, $logger);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->headers);
        unset($this->http_code);
        unset($this->status);
        unset($this->payload);
    }

    /**
     * Set notification status information.
     *
     * @param string          $endpoint The notification endpoint that was used.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     *
     * @return void
     */
    private function set_status(string $endpoint, LoggerInterface $logger)
    {
        switch ($this->http_code)
        {
            case 200:
                if ($this->headers['X-WNS-Status'] === 'received')
                {
                    $this->status = PushNotificationStatus::Success;
                }
                elseif ($this->headers['X-WNS-Status'] === 'channelthrottled')
                {
                    $this->status = PushNotificationStatus::TemporaryError;
                }
                else
                {
                    $this->status = PushNotificationStatus::ClientError;
                }

                break;
            case 404:
            case 410:
                $this->status = PushNotificationStatus::InvalidEndpoint;
                break;
            case 400:
            case 401:
            case 403:
            case 405:
            case 413:
                $this->status = PushNotificationStatus::Error;
                break;
            case 406:
            case 500:
            case 503:
                $this->status = PushNotificationStatus::TemporaryError;
                break;
            default:
                $this->status = PushNotificationStatus::Unknown;
                break;
        }

        if ($this->status !== PushNotificationStatus::Success)
        {
            $context = [
                'endpoint'          => $endpoint,
                'nstatus'           => $this->headers['X-WNS-Status'],
                'dstatus'           => $this->headers['X-WNS-DeviceConnectionStatus'],
                'error_description' => $this->headers['X-WNS-Error-Description'],
                'error_trace'       => $this->headers['X-WNS-Debug-Trace'],
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= '{nstatus}, device {dstatus}, description {error_description}, trace {error_trace}';

            $logger->warning($message, $context);
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
        if ($endpoint != $this->endpoint)
        {
            return PushNotificationStatus::Unknown;
        }

        return $this->status;
    }

}

?>
