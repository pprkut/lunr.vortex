<?php

/**
 * This file contains priority types for delivering JPush Notifications.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
