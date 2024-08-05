<?php

/**
 * This file contains the EmailPayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\Email\EmailPayload;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the EmailPayload class.
 *
 * @covers Lunr\Vortex\Email\EmailPayload
 */
abstract class EmailPayloadTest extends LunrBaseTest
{

    /**
     * Sample payload json
     * @var string
     */
    protected $payload;

    /**
     * Instance of the tested class.
     * @var EmailPayload&MockObject&Stub
     */
    protected EmailPayload&MockObject&Stub $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $elements_array = [
            'subject' => 'value1',
            'body'    => 'value2',
        ];

        $this->payload = json_encode($elements_array);

        $this->class = $this->getMockBuilder('Lunr\Vortex\Email\EmailPayload')
                            ->getMockForAbstractClass();

        parent::baseSetUp($this->class);
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->payload);
        unset($this->class);

        parent::tearDown();
    }

}

?>
