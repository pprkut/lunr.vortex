<?php

/**
 * This file contains visibility types for Firebase Cloud Messaging Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Notification Visibility Types.
 */
enum FCMVisibility: string
{

    /**
     * Show this notification on all lockscreens, but conceal sensitive or private information
     * on secure lockscreens. This is the default visibility.
     */
    case Private = 'PRIVATE';

    /**
     * Show this notification in its entirety on all lockscreens.
     */
    case Public = 'PUBLIC';

    /**
     * Do not reveal any part of this notification on a secure lockscreen.
     */
    case Secret = 'SECRET';

}

?>
