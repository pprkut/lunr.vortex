<?php

/**
 * This file contains the PushNotificationDeferredResponseInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex;

/**
 * Push notification deferred Response interface.
 */
interface PushNotificationDeferredResponseInterface extends PushNotificationResponseInterface
{

    /**
     * Get message_id for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return ?string Delivery batch info for an endpoint
     */
    public function get_message_id(string $endpoint): ?string;

}

?>
