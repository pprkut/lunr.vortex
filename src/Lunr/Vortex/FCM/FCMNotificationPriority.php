<?php

/**
 * This file contains priority types for Firebase Cloud Messaging Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Notification Priority Types.
 */
enum FCMNotificationPriority: string
{

    /**
     * Lowest notification priority. Notifications with this priority might not be shown to
     * the user except under special circumstances, such as detailed notification logs.
     */
    case Min = 'PRIORITY_MIN';

    /**
     * Lower notification priority. The UI may choose to show the notifications smaller,
     * or at a different position in the list, compared with notifications with `Default`.
     */
    case Low = 'PRIORITY_LOW';

    /**
     * Default notification priority. If the application does not prioritize its own notifications,
     * use this value for all notifications.
     */
    case Default = 'PRIORITY_DEFAULT';

    /**
     * Higher notification priority. Use this for more important notifications or alerts.
     * The UI may choose to show these notifications larger, or at a different position in the
     * notification lists, compared with notifications with `Default`.
     */
    case High = 'PRIORITY_HIGH';

    /**
     * Highest notification priority. Use this for the application's most important items that
     * require the user's prompt attention or input.
     */
    case Max = 'PRIORITY_MAX';

}

?>
