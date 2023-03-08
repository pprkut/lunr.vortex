<?php

/**
 * This file contains Apple Push Notification Service stream status codes.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\APNS\ApnsPHP;

/**
 * Apple Push Notification Service status codes.
 */
class APNSHttpStatus
{

    /**
     * No error encountered.
     * @var integer
     */
    public const SUCCESS = 200;

    /**
     * Bad request error.
     * @var integer
     */
    public const ERROR_BAD_REQUEST = 400;

    /**
     * Certificate or token error.
     * @var integer
     */
    public const ERROR_AUTHENTICATION = 403;

    /**
     * The device token is inactive for the specified topic.
     * @var integer
     */
    public const ERROR_UNREGISTERED = 410;

    /**
     * The message payload was too large.
     * @var integer
     */
    public const ERROR_PAYLOAD_TOO_LARGE = 413;

    /**
     * The provider token is being updated too often.
     * @var integer
     */
    public const TOO_MANY_REQUESTS = 429;

    /**
     * Unknown internal error.
     * @var integer
     */
    public const ERROR_INTERNAL_ERROR = 500;

    /**
     * Shutdown error.
     * @var integer
     */
    public const ERROR_SHUTDOWN = 503;

}

?>
