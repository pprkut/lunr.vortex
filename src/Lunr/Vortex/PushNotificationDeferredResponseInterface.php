<?php

/**
 * This file contains the PushNotificationDeferredResponseInterface.
 *
 * @package   Lunr\Vortex
 * @author    Brian Stoop <brian.stoop@moveagency.com>
 * @copyright 2023, Move BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex;

/**
 * Push notification deferred Response interface.
 */
interface PushNotificationDeferredResponseInterface extends PushNotificationResponseInterface
{

    /**
     * Get message_id for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return ?string Delivery batch info for an endpoint
     */
    public function get_message_id(string $endpoint): ?string;

}

?>
