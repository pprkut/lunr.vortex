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
class APNSBinaryStatus
{

    /**
     * No error encountered.
     * @var integer
     */
    public const SUCCESS = 0;

    /**
     * Processing error.
     * @var integer
     */
    public const ERROR_PROCESSING = 1;

    /**
     * Missing device token error.
     * @var integer
     */
    public const ERROR_MISSING_DEVICE_TOKEN = 2;

    /**
     * Missing topic error.
     * @var integer
     */
    public const ERROR_TOPIC = 3;

    /**
     * Missing payload error.
     * @var integer
     */
    public const ERROR_MISSING_PAYLOAD = 4;

    /**
     * Invalid token size error.
     * @var integer
     */
    public const ERROR_INVALID_TOKEN_SIZE = 5;

    /**
     * Invalid topic size error.
     * @var integer
     */
    public const ERROR_INVALID_TOPIC_SIZE = 6;

    /**
     * Invalid payload size error.
     * @var integer
     */
    public const ERROR_INVALID_PAYLOAD_SIZE = 7;

    /**
     * Invalid token error.
     * @var integer
     */
    public const ERROR_INVALID_TOKEN = 8;

    /**
     * Shutdown error.
     * @var integer
     */
    public const ERROR_SHUTDOWN = 10;

    /**
     * Protocol error,
     * @var integer
     */
    public const ERROR_PROTOCOL = 128;

    /**
     * Unknown error.
     * @var integer
     */
    public const ERROR_UNKNOWN = 255;

}

?>
