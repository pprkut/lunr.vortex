<?php

/**
 * This file contains the JPushReport class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush;

use Lunr\Vortex\PushNotificationStatus;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Exception\Http as RequestsExceptionHTTP;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;

/**
 * JPush report for push notifications.
 */
class JPushReport
{

    /**
     * JPush Report API URL.
     * @var string
     */
    private const JPUSH_REPORT_URL = 'https://report.jpush.cn/v3/status/message';

    /**
     * Shared instance of a Logger class.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * Shared instance of the Requests\Session class.
     * @var Session
     */
    protected Session $http;

    /**
     * Push Notification authentication token.
     * @var string|null
     */
    protected ?string $auth_token;

    /**
     * The statuses per endpoint.
     * @var array
     */
    private array $statuses;

    /**
     * Constructor.
     *
     * @param Session         $http   Shared instance of the Requests\Session class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct(Session $http, LoggerInterface $logger)
    {
        $this->statuses   = [];
        $this->http       = $http;
        $this->logger     = $logger;
        $this->auth_token = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->http);
        unset($this->logger);
        unset($this->statuses);
        unset($this->auth_token);
    }

    /**
     * Fetch report from JPush and set statuses when report is fetched successfully
     *
     * @param int   $message_id JPush Batch ID
     * @param array $endpoints  The endpoints the message was sent to (in the same order as sent).
     *
     * @return void
     */
    public function get_report($message_id, $endpoints): void
    {
        $payload = [
            'msg_id'           => $message_id,
            'registration_ids' => $endpoints,
        ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . $this->auth_token,
        ];

        try
        {
            $response = $this->http->post(self::JPUSH_REPORT_URL, $headers, json_encode($payload), []);
            $response->throw_for_status();
        }
        catch (RequestsExceptionHTTP $e)
        {
            $this->report_error($response, $endpoints);
            return;
        }
        catch (RequestsException $e)
        {
            foreach ($endpoints as $endpoint)
            {
                $this->statuses[$endpoint] = PushNotificationStatus::ERROR;
            }

            $context = [ 'error' => $e->getMessage() ];
            $this->logger->warning('Getting JPush notification report failed: {error}', $context);
            return;
        }

        foreach (json_decode($response->body, TRUE) as $endpoint => $result)
        {
            if ($result['status'] === 0)
            {
                $this->statuses[$endpoint] = PushNotificationStatus::SUCCESS;
            }
            else
            {
                $this->report_endpoint_error($endpoint, $result['status']);
            }
        }
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus::* Delivery status for the endpoint
     */
    public function get_status(string $endpoint): int
    {
        return $this->statuses[$endpoint] ?? PushNotificationStatus::UNKNOWN;
    }

    /**
     * Report an error with the push notification.
     *
     * @param Response $response  The HTTP Response
     * @param array    $endpoints The endpoints the message was sent to (in the same order as sent).
     *
     * @see https://docs.jiguang.cn/en/jpush/server/push/rest_api_v3_push/#call-return
     *
     * @return void
     */
    private function report_error(Response $response, array &$endpoints): void
    {
        $upstream_msg  = NULL;
        $upstream_code = NULL;

        if (!empty($response->body))
        {
            $body          = json_decode($response->body, TRUE);
            $upstream_msg  = $body['error']['message'] ?? NULL;
            $upstream_code = $body['error']['code'] ?? NULL;
        }

        $status = PushNotificationStatus::ERROR;

        switch ($response->status_code)
        {
            case 400:
                if ($upstream_code === 3002)
                {
                    $status = PushNotificationStatus::DEFERRED;
                }

                $error_message = $upstream_msg ?? 'Invalid request';
                break;
            case 401:
                $error_message = $upstream_msg ?? 'Error with authentication';
                break;
            case 403:
                $error_message = $upstream_msg ?? 'Error with configuration';
                break;
            default:
                $error_message = $upstream_msg ?? 'Unknown error';
                $status        = PushNotificationStatus::UNKNOWN;
                break;
        }

        if ($response->status_code >= 500)
        {
            $error_message = $upstream_msg ?? 'Internal error';
            $status        = PushNotificationStatus::TEMPORARY_ERROR;
        }

        foreach ($endpoints as $endpoint)
        {
            $this->statuses[$endpoint] = $status;
        }

        $context = [ 'error' => $error_message ];
        $this->logger->warning('Getting JPush notification report failed: {error}', $context);
    }

    /**
     * Report an error with the push notification for one endpoint.
     *
     * @param string $endpoint   Endpoint for which the push failed
     * @param string $error_code Error response code
     *
     * @see https://docs.jiguang.cn/en/jpush/server/push/rest_api_v3_report/#inquiry-of-service-status
     *
     * @return void
     */
    private function report_endpoint_error(string $endpoint, string $error_code): void
    {
        switch ($error_code)
        {
            case 1:
                $status        = PushNotificationStatus::UNKNOWN;
                $error_message = 'Not delivered';
                break;
            case 2:
                $status        = PushNotificationStatus::INVALID_ENDPOINT;
                $error_message = 'Registration_id does not belong to the application';
                break;
            case 3:
                $status        = PushNotificationStatus::ERROR;
                $error_message = 'Registration_id belongs to the application, but it is not the target of the message';
                break;
            case 4:
                $status        = PushNotificationStatus::TEMPORARY_ERROR;
                $error_message = 'The system is abnormal';
                break;
            default:
                $status        = PushNotificationStatus::UNKNOWN;
                $error_message = $error_code;
                break;
        }

        $context = [ 'endpoint' => $endpoint, 'error' => $error_message ];
        $this->logger->warning('Dispatching push notification failed for endpoint {endpoint}: {error}', $context);

        $this->statuses[$endpoint] = $status;
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the JPush push notifications
     *
     * @return void
     */
    public function set_auth_token(string $auth_token): void
    {
        $this->auth_token = $auth_token;
    }

}

?>
