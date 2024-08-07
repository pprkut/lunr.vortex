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

/**
 * Firebase Cloud Messaging Push Notification response wrapper.
 */
class FCMResponse implements PushNotificationResponseInterface
{

    /**
     * The statuses per endpoint.
     * @var array<string, PushNotificationStatus::*>
     */
    protected array $statuses;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->statuses = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->statuses);
    }

    /**
     * Add the results of a batch response.
     *
     * @param FCMBatchResponse $batch_response Batch response
     * @param string[]         $endpoints      Endpoints of the batch
     *
     * @return void
     */
    public function add_batch_response(FCMBatchResponse $batch_response, array $endpoints): void
    {
        foreach($endpoints as $endpoint)
        {
            $this->statuses[$endpoint] = $batch_response->get_status($endpoint);
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
        return isset($this->statuses[$endpoint]) ? $this->statuses[$endpoint] : PushNotificationStatus::Unknown;
    }

}

?>
