<?php

/**
 * Push Notification delivery status.
 *
 * @package    Lunr\Vortex
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
