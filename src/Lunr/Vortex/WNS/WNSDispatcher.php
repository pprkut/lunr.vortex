<?php

/**
 * This file contains functionality to dispatch Windows Push Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use Lunr\Vortex\PushNotificationResponseInterface;
use Psr\Log\LoggerInterface;
use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Response;
use WpOrg\Requests\Session;
use InvalidArgumentException;
use RuntimeException;
use UnexpectedValueException;

/**
 * Windows Push Notification Dispatcher.
 */
class WNSDispatcher implements PushNotificationDispatcherInterface
{
    /**
     * Client Secret to use when obtaining an oauth token
     * @var string|null
     */
    protected ?string $client_secret;

    /**
     * Client ID to use when obtaining an oauth token
     * @var string|null
     */
    protected ?string $client_id;

    /**
     * The authentication token to identify the app channel
     * @var string|null
     */
    private ?string $oauth_token;

    /**
     * Push notification type.
     * @var string
     */
    private string $type;

    /**
     * Shared instance of the Requests\Session class.
     * @var Session
     */
    private Session $http;

    /**
     * Shared instance of a Logger class.
     *
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * The URL to use to request an OAuth token.
     * @var string
     */
    private const TOKEN_URL = 'https://login.live.com/accesstoken.srf';

    /**
     * The scope to request the oauth token from.
     * @var string
     */
    private const NOTIFICATION_SCOPE = 'notify.windows.com';

    /**
     * Constructor.
     *
     * @param Session         $http   Shared instance of the Requests\Session class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct(Session $http, LoggerInterface $logger)
    {
        $this->http          = $http;
        $this->logger        = $logger;
        $this->type          = WNSType::RAW;
        $this->client_id     = NULL;
        $this->client_secret = NULL;
        $this->oauth_token   = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->type);
        unset($this->http);
        unset($this->logger);
        unset($this->client_id);
        unset($this->client_secret);
        unset($this->oauth_token);
    }

    /**
     * Push the notification.
     *
     * @param object $payload   Payload object
     * @param array  $endpoints Endpoints to send to in this batch
     *
     * @return WNSResponse Response object
     */
    public function push(object $payload, array &$endpoints): WNSResponse
    {
        if (!$payload instanceof WNSPayload)
        {
            throw new InvalidArgumentException('Invalid payload object!');
        }

        if (!isset($this->oauth_token))
        {
            $this->logger->warning('Tried to push WNS notification to {endpoint} but wasn\'t authenticated.', [ 'endpoint' => $endpoints[0] ]);
            $response = $this->get_new_response_object_for_failed_request($endpoints[0]);

            $this->type = WNSType::RAW;

            return new WNSResponse($response, $this->logger, NULL);
        }

        if ($payload instanceof WNSToastPayload)
        {
            $this->set_type(WNSType::TOAST);
        }
        elseif ($payload instanceof WNSTilePayload)
        {
            $this->set_type(WNSType::TILE);
        }
        elseif ($payload instanceof WNSBadgePayload)
        {
            $this->set_type(WNSType::BADGE);
        }
        else
        {
            $this->set_type(WNSType::RAW);
        }

        $headers = [
            'X-WNS-Type'             => 'wns/' . $this->type,
            'Accept'                 => 'application/*',
            'Authorization'          => 'Bearer ' . $this->oauth_token,
            'X-WNS-RequestForStatus' => 'true',
        ];

        if ($this->type === WNSType::RAW)
        {
            $headers['Content-Type'] = 'application/octet-stream';
        }
        else
        {
            $headers['Content-Type'] = 'text/xml';
        }

        $raw_payload = $payload->get_payload();

        try
        {
            $response = $this->http->post($endpoints[0], $headers, $raw_payload);
        }
        catch (RequestsException $e)
        {
            $response = $this->get_new_response_object_for_failed_request($endpoints[0]);
            $context  = [ 'error' => $e->getMessage(), 'endpoint' => $endpoints[0] ];

            $this->logger->warning('Dispatching WNS notification to {endpoint} failed: {error}', $context);
        }

        $this->type = WNSType::RAW;

        return new WNSResponse($response, $this->logger, $raw_payload);
    }

    /**
     * Set the type for the push notification.
     *
     * @param string $type Type for the push notification.
     *
     * @return WNSDispatcher Self reference
     */
    public function set_type(string $type): self
    {
        if (in_array($type, [ WNSType::TOAST, WNSType::TILE, WNSType::RAW, WNSType::BADGE ]))
        {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Set the client_id for the oauth request
     *
     * @param string $client_id The client id from the Windows Dashboard
     *
     * @return WNSDispatcher Self reference
     */
    public function set_client_id(string $client_id): self
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * Set the client_secret for the oauth request
     *
     * @param string $client_secret The client secret from the Windows Dashboard
     *
     * @return WNSDispatcher Self reference
     */
    public function set_client_secret(string $client_secret): self
    {
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * Get an oath token from the microsoft webservice.
     *
     * @return string the oauth access token.
     */
    public function get_oauth_token(): string
    {
        $request_post = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'scope'         => self::NOTIFICATION_SCOPE,
        ];

        $headers = [ 'Content-Type' => 'application/x-www-form-urlencoded' ];

        try
        {
            /** @var Response */
            $response = $this->http->post(self::TOKEN_URL, $headers, $request_post);
        }
        catch (RequestsException $e)
        {
            $this->logger->warning('Requesting token failed: No response');
            throw new RuntimeException('Requesting token failed: No response');
        }

        $response_object = json_decode($response->body);

        if (!(json_last_error() === JSON_ERROR_NONE))
        {
            $this->logger->warning('Requesting token failed: Malformed JSON response');
            throw new UnexpectedValueException('Requesting token failed: Malformed JSON response');
        }

        if (!property_exists($response_object, 'access_token'))
        {
            $this->logger->warning('Requesting token failed: Not a valid JSON response');
            throw new UnexpectedValueException('Requesting token failed: Not a valid JSON response');
        }

        return $response_object->access_token;
    }

    /**
     * Set a token to authenticate with.
     *
     * @param string $token The OAuth token to use
     *
     * @return void
     */
    public function set_oauth_token(string $token): void
    {
        $this->oauth_token = $token;
    }

    /**
     * Request and set an oauth token from microsoft.
     *
     * @return void
     */
    public function configure_oauth_token(): void
    {
        $this->set_oauth_token($this->get_oauth_token());
    }

    /**
     * Get a Requests\Response object for a failed request.
     *
     * @param string $endpoint Endpoint to send to
     *
     * @return Response New instance of a Requests\Response object.
     */
    protected function get_new_response_object_for_failed_request(string $endpoint): Response
    {
        $http_response = new Response();

        $http_response->url = $endpoint;

        return $http_response;
    }

}

?>
