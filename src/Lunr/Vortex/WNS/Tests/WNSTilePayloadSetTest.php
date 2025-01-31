<?php

/**
 * This file contains the WNSTilePayloadSetTest class.
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
class WNSTilePayloadSetTest extends WNSTilePayloadTestCase
{

    /**
     * Test set_text() works correctly with strings.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetText(): void
    {
        $this->class->set_text('&text');

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals('&amp;text', $value['text'][0]);
    }

    /**
     * Test set_text() works correctly with line numbers.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextLN(): void
    {
        $this->class->set_text('&text', 1);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals('&amp;text', $value['text'][1]);
    }

    /**
     * Test set_text() works correctly with arrays.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextArray(): void
    {
        $this->class->set_text([ 'Hello', 'Text', 'Test' ]);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('text', $value);
        $this->assertEquals([ 'Hello', 'Text', 'Test' ], $value['text']);
    }

    /**
     * Test fluid interface of set_text().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_text
     */
    public function testSetTextReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_text('text'));
    }

    /**
     * Test set_image() works correctly with strings.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImage(): void
    {
        $this->class->set_image('&image');

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals('&amp;image', $value['image'][0]);
    }

    /**
     * Test set_image() works correctly with line numbers.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageLN(): void
    {
        $this->class->set_image('&image', 1);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals('&amp;image', $value['image'][1]);
    }

    /**
     * Test set_image() works correctly with arrays.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageArray(): void
    {
        $this->class->set_image([ 'Hello', 'Image', 'Test' ]);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('image', $value);
        $this->assertEquals([ 'Hello', 'Image', 'Test' ], $value['image']);
    }

    /**
     * Test fluid interface of set_image().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_image
     */
    public function testSetImageReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_image('image'));
    }

    /**
     * Test set_templates() works correctly.
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_templates
     */
    public function testSetTemplates(): void
    {
        $this->class->set_templates([ 'HelloSQ', 'HelloW' ]);

        $value = $this->getReflectionPropertyValue('elements');

        $this->assertArrayHasKey('templates', $value);
        $this->assertEquals([ 'HelloSQ', 'HelloW' ], $value['templates']);
    }

    /**
     * Test fluid interface of set_templates().
     *
     * @covers Lunr\Vortex\WNS\WNSTilePayload::set_templates
     */
    public function testSetTemplatesReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_templates('template', 'template'));
    }

}

?>
