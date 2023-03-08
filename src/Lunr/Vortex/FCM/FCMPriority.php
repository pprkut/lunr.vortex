<?php

/**
 * This file contains priority types for delivering Firebase Cloud Messaging Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Notification Priority Types.
 */
class FCMPriority
{

    /**
     * Deliver notification immediately.
     * @var string
     */
    public const HIGH = 'high';

    /**
     * Deliver notification with normal priority.
     * @var string
     */
    public const NORMAL = 'normal';

}

?>
