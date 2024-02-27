<?php

/**
 * This file contains functionality to generate Firebase Cloud Messaging Push Notification payloads.
 *
 * SPDX-FileCopyrightText: Copyright 2017 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Push Notification Payload Generator.
 */
class FCMPayload
{

    /**
     * Array of Push Notification elements.
     * @var array
     */
    protected array $elements;

    /**
     * The Android payload Push Notification Element.
     * @var ?FCMAndroidPayload
     */
    protected ?FCMAndroidPayload $android_payload;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements        = [];
        $this->android_payload = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
        unset($this->android_payload);
    }

    /**
     * Construct the payload for the push notification.
     *
     * @param int $flag The flag to encode the payload with
     *
     * @return string FCMPayload
     */
    public function get_json_payload(int $flag = 0): string
    {
        $payload = $this->elements;

        if ($this->android_payload !== NULL)
        {
            $payload['android'] = $this->android_payload->get_payload();
        }

        return json_encode([ 'message' => $payload ], $flag);
    }

    /**
     * Sets the payload key data.
     *
     * The fields of data represent the key-value pairs of the message's payload data.
     *
     * @param array $data The actual notification information
     *
     * @return FCMPayload Self Reference
     */
    public function set_data(array $data): self
    {
        $this->elements['data'] = $data;

        return $this;
    }

    /**
     * Check whether a condition is set
     *
     * @return bool TRUE if condition is present.
     */
    public function has_condition(): bool
    {
        return isset($this->elements['condition']);
    }

    /**
     * Check whether a condition is set
     *
     * @return bool TRUE if condition is present.
     */
    public function has_topic(): bool
    {
        return isset($this->elements['topic']);
    }

    /**
     * Sets the payload key notification.
     *
     * The fields of data represent the key-value pairs of the message's payload notification data.
     *
     * @param array $notification The actual notification information
     *
     * @return FCMPayload Self Reference
     */
    public function set_notification(array $notification): self
    {
        $this->elements['notification'] = $notification;

        return $this;
    }

    /**
     * Sets the topic name to send the message to.
     *
     * @param string $topic String of the topic name
     *
     * @return FCMPayload Self Reference
     */
    public function set_topic(string $topic): self
    {
        $this->elements['topic'] = $topic;

        return $this;
    }

    /**
     * Sets the condition to send the message to. For example:
     * 'TopicA' in topics && ('TopicB' in topics || 'TopicC' in topics)
     *
     * You can include up to five topics in your conditional expression.
     * Conditions support the following operators: &&, ||, !
     *
     * @param string $condition Key-value pairs of payload data
     *
     * @return FCMPayload Self Reference
     */
    public function set_condition(string $condition): self
    {
        $this->elements['condition'] = $condition;

        return $this;
    }

    /**
     * Set additional FCM values in the 'fcm_options' key.
     *
     * @param string $key   Options key.
     * @param string $value Options value.
     *
     * @return FCMPayload Self Reference
     */
    public function set_options(string $key, string $value): self
    {
        $this->elements['fcm_options'][$key] = $value;

        return $this;
    }

    /**
     * Set the token of the target for the notification.
     *
     * @param string $token Token of the target for the notification.
     *
     * @return FCMPayload Self Reference
     */
    public function set_token(string $token): self
    {
        $this->elements['token'] = $token;

        return $this;
    }

    /**
     * Get the android payload element.
     *
     * @return FCMAndroidPayload
     */
    public function get_android_payload(): FCMAndroidPayload
    {
        return $this->android_payload ?? new FCMAndroidPayload();
    }

    /**
     * Set the android payload element.
     *
     * @param array|FCMAndroidPayload $payload The android payload element
     *
     * @return self self Reference
     */
    public function set_android_payload(array|FCMAndroidPayload $payload): self
    {
        if (is_array($payload))
        {
            $this->elements['android'] = $payload;

            return $this;
        }

        $this->android_payload = $payload;

        return $this;
    }

}

?>
