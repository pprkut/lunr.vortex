<?php

/**
 * This file contains functionality to dispatch
 * push notification messages in a generic manner.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex;

use Lunr\Vortex\PushNotificationStatus as Status;

/**
 * Generic Push Notification Dispatcher.
 */
class PushNotificationDispatcher
{

    /**
     * List of Push Notification dispatchers.
     * @var array<string, PushNotificationDispatcherInterface>
     */
    protected array $dispatchers;

    /**
     * List of Push Notification status codes for every endpoint.
     * @var array<value-of<PushNotificationStatus>, array>
     */
    protected array $statuses;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->dispatchers = [];
        $this->statuses    = [];

        foreach (PushNotificationStatus::cases() as $case)
        {
            $this->statuses[$case->value] = [];
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->dispatchers);
        unset($this->statuses);
    }

    /**
     * Register a notification dispatcher.
     *
     * @param string                              $platform   The platform for which the dispatcher works.
     * @param PushNotificationDispatcherInterface $dispatcher Dispatcher for the notifications.
     *
     * @return void
     */
    public function register_dispatcher(string $platform, PushNotificationDispatcherInterface $dispatcher): void
    {
        $this->dispatchers[$platform] = $dispatcher;
    }

    /**
     * Push the notification.
     *
     * @param array $endpoints Array containing lists of endpoints
     *                         paired to their respective platform identifiers
     * @param array $payloads  Associative array containing payload strings
     *                         per platform identifier
     *
     * @return void
     */
    public function dispatch(array $endpoints, array $payloads): void
    {
        $grouped_endpoints = [];

        foreach ($endpoints as $endpoint)
        {
            $grouped_endpoints[$endpoint['platform']][$endpoint['payloadType']][] = $endpoint;
        }

        foreach ($payloads as $platform => $platform_payloads)
        {
            if (!isset($grouped_endpoints[$platform]))
            {
                continue;
            }

            if (!isset($this->dispatchers[$platform]))
            {
                foreach ($grouped_endpoints[$platform] as $payload_endpoints)
                {
                    $this->statuses[Status::NotHandled->value] = array_merge($this->statuses[Status::NotHandled->value], $payload_endpoints);
                }

                continue;
            }

            foreach ($platform_payloads as $payload_type => $payload)
            {
                if (!isset($grouped_endpoints[$platform][$payload_type]))
                {
                    continue;
                }

                if ($this->dispatchers[$platform] instanceof PushNotificationMultiDispatcherInterface)
                {
                    $this->dispatch_multiple($platform, $grouped_endpoints[$platform][$payload_type], $payload);
                }
                else
                {
                    $this->dispatch_single($platform, $grouped_endpoints[$platform][$payload_type], $payload);
                }
            }
        }

        foreach ($grouped_endpoints as $platform => $platform_endpoints)
        {
            foreach ($platform_endpoints as $payload_type => $payload_endpoints)
            {
                if (isset($payloads[$platform][$payload_type]))
                {
                    continue;
                }

                if (isset($payloads[$platform]) && !isset($this->dispatchers[$platform]))
                {
                    continue;
                }

                $this->statuses[Status::NotHandled->value] = array_merge($this->statuses[Status::NotHandled->value], $payload_endpoints);
            }
        }
    }

    /**
     * Push a notification payload to each endpoint one by one
     *
     * @param string $platform  Notification platform
     * @param array  $endpoints Endpoints list
     * @param object $payload   Payload to send
     *
     * @return void
     */
    protected function dispatch_single(string $platform, array &$endpoints, object $payload): void
    {
        foreach ($endpoints as $endpoint)
        {
            $endpoints = [ $endpoint['endpoint'] ];

            $response = $this->dispatchers[$platform]->push($payload, $endpoints);

            $status = $response->get_status($endpoint['endpoint']);

            $this->statuses[$status->value][] = $endpoint;
        }
    }

    /**
     * Push a notification payload to each endpoint in a multicast way
     *
     * @param string $platform  Notification platform
     * @param array  $endpoints Endpoints list
     * @param object $payload   Payload to send
     *
     * @return void
     */
    protected function dispatch_multiple(string $platform, array &$endpoints, object $payload): void
    {
        $batch = array_column($endpoints, 'endpoint');

        $response = $this->dispatchers[$platform]->push($payload, $batch);

        foreach ($endpoints as $endpoint)
        {
            $status = $response->get_status($endpoint['endpoint']);

            if ($response instanceof PushNotificationDeferredResponseInterface && $status === PushNotificationStatus::Deferred)
            {
                $this->statuses[$status->value][] = $endpoint + [ 'message_id' => $response->get_message_id($endpoint['endpoint']) ];

                continue;
            }

            $this->statuses[$status->value][] = $endpoint;
        }
    }

    /**
     * Returns a list of endpoint & platform pairs for a given list of delivery status codes.
     *
     * @param value-of<PushNotificationStatus>[] $status_codes The list of status codes
     *
     * @return array The endpoint & platform pairs
     */
    public function get_endpoints_by_status(array $status_codes): array
    {
        $endpoints = [];

        foreach ($status_codes as $code)
        {
            if (!isset($this->statuses[$code]) || empty($this->statuses[$code]))
            {
                continue;
            }

            $endpoints[] = $this->statuses[$code];
        }

        if (!empty($endpoints))
        {
            $endpoints = call_user_func_array('array_merge', $endpoints);
        }

        return $endpoints;
    }

    /**
     * Return unfiltered status information.
     *
     * @return array Array of endpoint & platforms pairs structured by status.
     */
    public function get_statuses(): array
    {
        return $this->statuses;
    }

}

?>
