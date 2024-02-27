<?php

/**
 * This file contains the FCMAndroidPayloadSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMAndroidPriority;

/**
 * This class contains tests for the setters of the FCMAndroidPayload class.
 *
 * @covers \Lunr\Vortex\FCM\FCMAndroidPayload
 */
class FCMAndroidPayloadSetTest extends FCMAndroidPayloadTest
{

    /**
     * Test set_collapse_key() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMAndroidPayload::set_collapse_key
     */
    public function testSetCollapseKey(): void
    {
        $this->class->set_collapse_key('test');

        $value = $this->get_reflection_property_value('elements');
        $this->assertArrayHasKey('collapse_key', $value);
        $this->assertEquals('test', $value['collapse_key']);
    }

    /**
     * Test fluid interface of set_collapse_key().
     *
     * @covers Lunr\Vortex\FCM\FCMAndroidPayload::set_collapse_key
     */
    public function testSetCollapseKeyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_collapse_key('collapse_key'));
    }

    /**
     * Test set_time_to_live() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMAndroidPayload::set_time_to_live
     */
    public function testSetTimeToLive(): void
    {
        $this->class->set_time_to_live(5);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('ttl', $value);
        $this->assertEquals('5s', $value['ttl']);
    }

    /**
     * Test fluid interface of set_time_to_live().
     *
     * @covers Lunr\Vortex\FCM\FCMAndroidPayload::set_time_to_live
     */
    public function testSetTimeToLiveReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_time_to_live(15));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_priority
     */
    public function testSetPriority(): void
    {
        $this->class->set_priority(FCMAndroidPriority::Normal);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals('NORMAL', $value['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_priority(FCMAndroidPriority::High));
    }

    /**
     * Test set_category() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_category
     */
    public function testSetCategory()
    {
        $this->class->set_category('category');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertArrayHasKey('click_action', $value['notification']);
        $this->assertEquals('category', $value['notification']['click_action']);
    }

    /**
     * Test fluid interface of set_category().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_category
     */
    public function testSetCategoryReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_category('category'));
    }

    /**
     * Test set_tag() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_tag
     */
    public function testSetTag()
    {
        $this->class->set_tag('tag');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertArrayHasKey('tag', $value['notification']);
        $this->assertEquals('tag', $value['notification']['tag']);
    }

    /**
     * Test fluid interface of set_tag().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_tag
     */
    public function testSetTagReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_tag('tag'));
    }

    /**
     * Test set_color() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_color
     */
    public function testSetColor()
    {
        $this->class->set_color('red');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertArrayHasKey('color', $value['notification']);
        $this->assertEquals('red', $value['notification']['color']);
    }

    /**
     * Test fluid interface of set_color().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_color
     */
    public function testSetColorReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_color('red'));
    }

    /**
     * Test set_icon() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_icon
     */
    public function testSetIcon()
    {
        $this->class->set_icon('icon');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertArrayHasKey('icon', $value['notification']);
        $this->assertEquals('icon', $value['notification']['icon']);
    }

    /**
     * Test fluid interface of set_icon().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_icon
     */
    public function testSetIconReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_icon('icon'));
    }

    /**
     * Test set_sound() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_sound
     */
    public function testSetSound()
    {
        $this->class->set_sound('sound');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertArrayHasKey('sound', $value['notification']);
        $this->assertEquals('sound', $value['notification']['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers \Lunr\Vortex\FCM\FCMAndroidPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

}

?>
