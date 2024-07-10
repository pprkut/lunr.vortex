<?php

/**
 * This file contains functionality to generate Windows Badge Push Notification payloads.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS;

/**
 * Windows Badge Push Notification Payload Generator.
 *
 * @phpstan-type WNSBadgePayloadElements array{
 *     value?: string
 * }
 */
class WNSBadgePayload extends WNSPayload
{

    /**
     * Array of Push Notification elements.
     * @var WNSBadgePayloadElements
     */
    protected array $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->elements = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
        parent::__destruct();
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return string Payload
     */
    public function get_payload(): string
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if (isset($this->elements['value']))
        {
            $xml .= '<badge value="' . $this->elements['value'] . '"/>';
        }

        return $xml;
    }

    /**
     * Set text for the Badge notification.
     *
     * @param string $value Value on the Badge
     *
     * @see https://msdn.microsoft.com/en-us/library/windows/apps/br212849.aspx
     *
     * @return WNSBadgePayload Self Reference
     */
    public function set_value(string $value): self
    {
        $this->elements['value'] = $this->escape_string($value);

        return $this;
    }

}

?>
