<?php

/**
 * This file contains notification types for Windows Push Notifications.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS;

/**
 * Windows Push Notification Types.
 */
class WNSType
{

    /**
     * Tile notification.
     * @var string
     */
    public const TILE = 'tile';

    /**
     * Toast notification.
     * @var string
     */
    public const TOAST = 'toast';

    /**
     * Badge notification.
     * @var string
     */
    public const BADGE = 'badge';

    /**
     * Raw notification.
     * @var string
     */
    public const RAW = 'raw';

}

?>
