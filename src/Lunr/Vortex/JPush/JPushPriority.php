<?php

/**
 * This file contains priority types for delivering JPush Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush;

/**
 * JPush Notification Priority Types.
 */
class JPushPriority
{

    /**
     * Deliver notification immediately.
     * @var int
     */
    public const HIGH = 2;

    /**
     * Deliver notification with medium priority.
     * @var int
     */
    public const MEDIUM = 1;

    /**
     * Deliver notification with normal priority.
     * @var int
     */
    public const NORMAL = 0;

    /**
     * Deliver notification with low priority.
     * @var int
     */
    public const LOW = -1;

    /**
     * Deliver notification with no priority.
     * @var int
     */
    public const NONE = -2;

}

?>
