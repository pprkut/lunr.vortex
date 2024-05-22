<?php

/**
 * This file contains the JPushPayloadTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2020 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushPayload;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Stub;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushPayload class.
 *
 * @covers Lunr\Vortex\JPush\JPushPayload
 */
abstract class JPushPayloadTest extends LunrBaseTest
{

    /**
     * Sample payload json
     * @var string
     */
    protected $payload;

    /**
     * Instance of the tested class.
     * @var JPushPayload&MockObject&Stub
     */
    protected JPushPayload&MockObject&Stub $class;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $elements_array = [
            'registration_ids' => [ 'one', 'two', 'three' ],
            'collapse_key'     => 'test',
            'data'             => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'time_to_live'     => 10,
        ];

        $this->payload = json_encode($elements_array);

        $this->class = $this->getMockBuilder('Lunr\Vortex\JPush\JPushPayload')
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
