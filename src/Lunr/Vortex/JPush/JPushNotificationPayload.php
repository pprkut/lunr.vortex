<?php

/**
 * This file contains functionality to generate JPush Notification payloads.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

use ReflectionClass;

/**
 * JPush Notification Payload Generator.
 */
class JPushNotificationPayload extends JPushPayload
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->set_priority(JPushPriority::HIGH);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return array JPushPayload
     */
    public function get_payload(): array
    {
        $elements = $this->elements;

        unset($elements['message']);
        unset($elements['notification_3rd']);

        return $elements;
    }

    /**
     * Sets the payload sound data.
     *
     * @param string $sound The notification sound
     *
     * @return JPushNotificationPayload Self Reference
     */
    public function set_sound(string $sound): self
    {
        return $this->set_notification_data('sound', $sound);
    }

    /**
     * Sets the notification as providing content.
     *
     * @param bool $val Value for the "content_available" field.
     *
     * @return JPushNotificationPayload Self Reference
     */
    public function set_content_available(bool $val): self
    {
        return $this->set_notification_data('content-available', $val, [ 'ios' ]);
    }

    /**
     * Mark the notification as mutable.
     *
     * @param bool $mutable Notification mutable_content value.
     *
     * @return JPushNotificationPayload Self Reference
     */
    public function set_mutable_content(bool $mutable): self
    {
        return $this->set_notification_data('mutable-content', $mutable, [ 'ios' ]);
    }

    /**
     * Mark the notification priority.
     *
     * @param JPushPriority::* $priority Notification priority value.
     *
     * @return JPushNotificationPayload Self Reference
     */
    public function set_priority(int $priority): self
    {
        $priority_class = new ReflectionClass('\Lunr\Vortex\JPush\JPushPriority');
        $priorities     = array_values($priority_class->getConstants());
        if (in_array($priority, $priorities, TRUE))
        {
            $this->set_notification_data('priority', $priority, [ 'android' ]);
        }

        return $this;
    }

}

?>
