<?php

/**
 * This file contains the JPushNotificationPayloadSetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the setters of the JPushNotificationPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotificationPayload
 */
class JPushNotificationPayloadSetTest extends JPushNotificationPayloadTest
{

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_priority
     */
    public function testSetPriority(): void
    {
        $this->class->set_priority(1);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value['notification']['android']);
        $this->assertEquals(1, $value['notification']['android']['priority']);
    }

    /**
     * Test set_priority() works correctly with an invalid priority.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_priority
     */
    public function testSetPriorityInvalid(): void
    {
        $this->class->set_priority(25);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value['notification']['android']);
        $this->assertEquals(2, $value['notification']['android']['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_priority(1));
    }

    /**
     * Test set_mutable_content() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_mutable_content
     */
    public function testSetMutableContent(): void
    {
        $this->class->set_mutable_content(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('mutable-content', $value['notification']['ios']);
        $this->assertEquals(TRUE, $value['notification']['ios']['mutable-content']);
    }

    /**
     * Test fluid interface of set_mutable_content().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_mutable_content
     */
    public function testSetMutableContentReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_mutable_content(TRUE));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_content_available
     */
    public function testSetContentAvailable(): void
    {
        $this->class->set_content_available(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('content-available', $value['notification']['ios']);
        $this->assertEquals(TRUE, $value['notification']['ios']['content-available']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_content_available
     */
    public function testSetContentAvailableReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_content_available(TRUE));
    }

    /**
     * Test set_sound() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_sound
     */
    public function testSetSound(): void
    {
        $this->class->set_sound('sound');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('sound', $value['notification']['android']);
        $this->assertEquals('sound', $value['notification']['android']['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotificationPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

}

?>
