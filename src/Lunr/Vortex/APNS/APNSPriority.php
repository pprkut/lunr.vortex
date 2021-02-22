<?php

/**
 * This file contains priority types for delivering APNS Notifications.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS;

/**
 * APNS Priority Types.
 */
class APNSPriority
{

    /**
     * Deliver notification immediately.
     * @var int
     */
    public const HIGH = 10;

    /**
     * Deliver notification with normal priority.
     * @var int
     */
    public const NORMAL = 5;

}

?>
