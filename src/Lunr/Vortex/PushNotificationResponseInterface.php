<?php

/**
 * This file contains the PushNotificationResponseInterface.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex;

/**
 * Push notification Response interface.
 */
interface PushNotificationResponseInterface
{

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus::* Delivery status for the endpoint
     */
    public function get_status(string $endpoint): int;

}

?>
