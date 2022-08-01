<?php

/**
 * This file contains the JPushNotification3rdPayloadSetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the setters of the JPushNotification3rdPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload
 */
class JPushNotification3rdPayloadSetTest extends JPushNotification3rdPayloadTest
{

    /**
     * Test set_sound() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::set_sound
     */
    public function testSetSound(): void
    {
        $this->class->set_sound('sound');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('sound', $value['notification_3rd']);
        $this->assertEquals('sound', $value['notification_3rd']['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers \Lunr\Vortex\JPush\JPushNotification3rdPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

}

?>
