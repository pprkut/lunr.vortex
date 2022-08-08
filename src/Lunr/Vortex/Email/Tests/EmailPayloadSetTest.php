<?php

/**
 * This file contains the EmailPayloadSetTest class.
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the setters of the EmailPayload class.
 *
 * @covers Lunr\Vortex\Email\EmailPayload
 */
class EmailPayloadSetTest extends EmailPayloadTest
{

    /**
     * Test set_subject() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_subject
     */
    public function testSetSubject(): void
    {
        $this->class->set_subject('subject');

        $value = $this->get_reflection_property_value('elements');

        $expected = [
            'charset'  => 'UTF-8',
            'encoding' => 'base64',
            'subject'  => 'subject',
        ];

        $this->assertArrayHasKey('subject', $value);
        $this->assertEquals($expected, $value);
    }

    /**
     * Test fluid interface of set_subject().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_subject
     */
    public function testSetSubjectReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_subject('subject'));
    }

    /**
     * Test set_body() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_body
     */
    public function testSetBody(): void
    {
        $this->class->set_body('body');

        $value = $this->get_reflection_property_value('elements');

        $expected = [
            'charset'  => 'UTF-8',
            'encoding' => 'base64',
            'body'     => 'body',
        ];

        $this->assertArrayHasKey('body', $value);
        $this->assertEquals($expected, $value);
    }

    /**
     * Test fluid interface of set_body().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_body
     */
    public function testSetBodyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_body('subject'));
    }

    /**
     * Test set_charset() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_charset
     */
    public function testSetCharset(): void
    {
        $this->class->set_charset('UTF-16');

        $value = $this->get_reflection_property_value('elements');

        $expected = [
            'charset'  => 'UTF-16',
            'encoding' => 'base64',
        ];

        $this->assertArrayHasKey('charset', $value);
        $this->assertEquals($expected, $value);
    }

    /**
     * Test fluid interface of set_charset().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_charset
     */
    public function testSetCharsetReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_charset('UTF-16'));
    }

    /**
     * Test set_encoding() works correctly.
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_encoding
     */
    public function testSetEncoding(): void
    {
        $this->class->set_encoding('binary');

        $value = $this->get_reflection_property_value('elements');

        $expected = [
            'charset'  => 'UTF-8',
            'encoding' => 'binary',
        ];

        $this->assertArrayHasKey('encoding', $value);
        $this->assertEquals($expected, $value);
    }

    /**
     * Test fluid interface of set_encoding().
     *
     * @covers Lunr\Vortex\Email\EmailPayload::set_encoding
     */
    public function testSetEncodingReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_encoding('binary'));
    }

}

?>
