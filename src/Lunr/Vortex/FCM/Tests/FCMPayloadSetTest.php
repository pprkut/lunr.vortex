<?php

/**
 * This file contains the FCMPayloadSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\FCM\Tests;

use InvalidArgumentException;

/**
 * This class contains tests for the setters of the FCMPayload class.
 *
 * @covers \Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadSetTest extends FCMPayloadTest
{

    /**
     * Test set_notification() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_notification
     */
    public function testSetNotification(): void
    {
        $this->class->set_notification([ 'key' => 'value' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertEquals([ 'key' => 'value' ], $value['notification']);
    }

    /**
     * Test fluid interface of set_notification().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_notification
     */
    public function testSetNotificationReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_notification([]));
    }

    /**
     * Test set_data() decodes array value to string.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetDataThrowsExceptionWhenArrayValueIsNotString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Data type of test_key must be a string!');

        $this->class->set_data([ 'test_key' => [ 'value_key' => 'value' ] ]);

        $this->get_reflection_property_value('elements');
    }

    /**
     * Test set_data() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetData(): void
    {
        $this->class->set_data([ 'key' => 'value' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('data', $value);
        $this->assertEquals([ 'key' => 'value' ], $value['data']);
    }

    /**
     * Test fluid interface of set_data().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_data([ 'key' => 'value' ]));
    }

    /**
     * Test set_topic() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_topic
     */
    public function testSetTopic(): void
    {
        $this->class->set_topic('News');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('topic', $value);
        $this->assertEquals('News', $value['topic']);

        $this->assertArrayNotHasKey('token', $value);
        $this->assertArrayNotHasKey('condition', $value);
    }

    /**
     * Test fluid interface of set_topic().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_topic
     */
    public function testSetTopicReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_topic('data'));
    }

    /**
     * Test set_condition() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_condition
     */
    public function testSetCondition(): void
    {
        $this->class->set_condition("'TopicA' in topics && 'TopicB' in topics");

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('condition', $value);
        $this->assertEquals("'TopicA' in topics && 'TopicB' in topics", $value['condition']);

        $this->assertArrayNotHasKey('token', $value);
        $this->assertArrayNotHasKey('topic', $value);
    }

    /**
     * Test fluid interface of set_condition().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_condition
     */
    public function testSetConditionReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_condition('data'));
    }

    /**
     * Test set_options() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_options
     */
    public function testSetOptions()
    {
        $this->class->set_options('analytics_label', 'fooBar');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('fcm_options', $value);
        $this->assertArrayHasKey('analytics_label', $value['fcm_options']);
        $this->assertEquals('fooBar', $value['fcm_options']['analytics_label']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_options
     */
    public function testSetOptionsReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_options('analytics_label', 'fooBar'));
    }

    /**
     * Test set_token() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_token
     */
    public function testSetToken()
    {
        $this->class->set_token('endpoint_token');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('token', $value);
        $this->assertEquals('endpoint_token', $value['token']);

        $this->assertArrayNotHasKey('condition', $value);
        $this->assertArrayNotHasKey('topic', $value);
    }

    /**
     * Test fluid interface of set_token().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_token
     */
    public function testSetTokenReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_token('endpoint_token'));
    }

}

?>
