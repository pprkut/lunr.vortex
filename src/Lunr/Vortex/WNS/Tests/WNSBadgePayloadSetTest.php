<?php

/**
 * This file contains the WNSBadgePayloadSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSBadgePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSBadgePayload
 */
class WNSBadgePayloadSetTest extends WNSBadgePayloadTestCase
{

    /**
     * Test set_value() works correctly.
     *
     * @covers Lunr\Vortex\WNS\WNSBadgePayload::set_value
     */
    public function testSetValue(): void
    {
        $this->class->set_value(1);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('value', $value);
        $this->assertEquals(1, $value['value']);
    }

    /**
     * Test fluid interface of set_value().
     *
     * @covers Lunr\Vortex\WNS\WNSBadgePayload::set_value
     */
    public function testSetValueReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_value('text'));
    }

}

?>
