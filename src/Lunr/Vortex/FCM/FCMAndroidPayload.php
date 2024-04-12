<?php

/**
 * This file contains functionality to generate Firebase Cloud Messaging Push Notification payloads for android.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Push Notification Android Payload Generator.
 */
class FCMAndroidPayload
{

    /**
     * Array of Push Notification elements.
     * @var FcmAndroidConfig
     */
    protected array $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [];

        $this->elements['priority'] = FCMAndroidPriority::High->value;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
    }

    /**
     * Construct the android payload for the fcm push notification.
     *
     * @return FcmAndroidConfig
     */
    public function get_payload(): array
    {
        return $this->elements;
    }

    /**
     * Sets the payload key collapse_key.
     *
     * An arbitrary string that is used to collapse a group of alike messages
     * when the device is offline, so that only the last message gets sent to the client.
     *
     * @param string $key The notification collapse key identifier
     *
     * @return $this
     */
    public function set_collapse_key(string $key): static
    {
        $this->elements['collapse_key'] = $key;

        return $this;
    }

    /**
     * Sets the payload key ttl for android devices.
     *
     * It defines how long (in seconds) the message should be kept on the Android storage,
     * if the device is offline.
     *
     * @param int $ttl The time in seconds for the notification to stay alive
     *
     * @return $this
     */
    public function set_time_to_live(int $ttl): static
    {
        $this->elements['ttl'] = $ttl . 's';

        return $this;
    }

    /**
     * Mark the notification priority.
     *
     * @param FCMAndroidPriority $priority Notification priority value.
     *
     * @return $this
     */
    public function set_priority(FCMAndroidPriority $priority): static
    {
        $this->elements['priority'] = $priority->value;

        return $this;
    }

    /**
     * Sets the payload category.
     *
     * @param string $category The category to set it to
     *
     * @return $this
     */
    public function set_category(string $category): static
    {
        $this->elements['notification']['click_action'] = $category;

        return $this;
    }

    /**
     * Sets the tag of the notification for android notifications.
     *
     * @param string $tag The tag to set it to
     *
     * @return $this
     */
    public function set_tag(string $tag): static
    {
        $this->elements['notification']['tag'] = $tag;

        return $this;
    }

    /**
     * Sets the color of the notification for android notifications.
     *
     * @param string $color The color to set it to
     *
     * @return $this
     */
    public function set_color(string $color): static
    {
        $this->elements['notification']['color'] = $color;

        return $this;
    }

    /**
     * Sets the icon of the notification for android notifications.
     *
     * @param string $icon The icon to set it to
     *
     * @return $this
     */
    public function set_icon(string $icon): static
    {
        $this->elements['notification']['icon'] = $icon;

        return $this;
    }

    /**
     * Sets the notification sound.
     *
     * @param string $sound The sound to set it to
     *
     * @return $this
     */
    public function set_sound(string $sound): static
    {
        $this->elements['notification']['sound'] = $sound;

        return $this;
    }

}

?>
