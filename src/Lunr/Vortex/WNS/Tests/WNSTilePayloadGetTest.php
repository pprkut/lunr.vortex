<?php

/**
 * This file contains the WNSTilePayloadGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the setters of the WNSTilePayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSTilePayload
 */
class WNSTilePayloadGetTest extends WNSTilePayloadTest
{

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::get_payload
     */
    public function testGetPayload(): void
    {
        $file     = TEST_STATICS . '/Vortex/wns/tile.xml';
        $elements = [ 'text' => [ 'Text' ], 'templates' => [ 'TileSquare150x150Text04', 'TileWide310x150Text03' ], 'image' => [ 'image' ] ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringEqualsFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() without images being present.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::get_payload
     */
    public function testGetPayloadWithoutImage(): void
    {
        $file     = TEST_STATICS . '/Vortex/wns/tile_image.xml';
        $elements = [ 'text' => [ 'Text' ], 'templates' => [ 'TileSquare150x150Text04', 'TileWide310x150Text03' ], 'image' => [] ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringEqualsFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() without the wide template being present.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::get_payload
     */
    public function testGetPayloadWithoutWideTemplate(): void
    {
        $file     = TEST_STATICS . '/Vortex/wns/tile_square.xml';
        $elements = [ 'text' => [ 'Text' ], 'templates' => [ 'TileSquare150x150Text04' ], 'image' => [] ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringEqualsFile($file, $this->class->get_payload());
    }

}

?>
