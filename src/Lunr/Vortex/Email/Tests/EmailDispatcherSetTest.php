<?php

/**
 * This file contains the EmailDispatcherSetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

/**
 * This class contains tests for the setters of the EmailDispatcher class.
 *
 * @covers Lunr\Vortex\Email\EmailDispatcher
 */
class EmailDispatcherSetTest extends EmailDispatcherTestCase
{

    /**
     * Test that set_source() sets the auth_token.
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::set_source
     */
    public function testSetSourceSetsSource(): void
    {
        $source = 'source';
        $this->class->set_source($source);

        $this->assertPropertyEquals('source', 'source');
    }

    /**
     * Test the fluid interface of set_source().
     *
     * @covers Lunr\Vortex\Email\EmailDispatcher::set_source
     */
    public function testSetSourceReturnsSelfReference(): void
    {
        $source = 'source';
        $this->assertEquals($this->class, $this->class->set_source($source));
    }

}

?>
