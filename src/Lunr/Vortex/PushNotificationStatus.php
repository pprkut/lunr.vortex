<?php

/**
 * Push Notification delivery status.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex;

/**
 * Push notification delivery status.
 */
class PushNotificationStatus
{

    /**
     * Push notification status unknown.
     * @var integer
     */
    public const UNKNOWN = 0;

    /**
     * Push notification delivered successfully.
     * @var integer
     */
    public const SUCCESS = 1;

    /**
     * Push notification could not be delivered. Try again later.
     * @var integer
     */
    public const TEMPORARY_ERROR = 2;

    /**
     * Push notification endpoint invalid.
     * @var integer
     */
    public const INVALID_ENDPOINT = 3;

    /**
     * Push notification not delivered because of client misconfiguration.
     * @var integer
     */
    public const CLIENT_ERROR = 4;

    /**
     * Push notification not delivered because of server error.
     * @var integer
     */
    public const ERROR = 5;

    /**
     * Push notification not processed by any dispatcher.
     * @var integer
     */
    public const NOT_HANDLED = 6;

}

?>
