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
enum PushNotificationStatus: int
{

    /**
     * Push notification status unknown.
     */
    case Unknown = 0;

    /**
     * Push notification delivered successfully.
     */
    case Success = 1;

    /**
     * Push notification could not be delivered. Try again later.
     */
    case TemporaryError = 2;

    /**
     * Push notification endpoint invalid.
     */
    case InvalidEndpoint = 3;

    /**
     * Push notification not delivered because of client misconfiguration.
     */
    case ClientError = 4;

    /**
     * Push notification not delivered because of server error.
     */
    case Error = 5;

    /**
     * Push notification not processed by any dispatcher.
     */
    case NotHandled = 6;

    /**
     * Push notification status will be fetched at a later time.
     */
    case Deferred = 7;

}

?>
