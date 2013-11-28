<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements.  See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License.  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category   tests
 * @license    http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @link       http://logging.apache.org/log4php
 */

namespace Apache\Log4php\Tests\Helpers;

use Apache\Log4php\Helpers\Utils;

/**
 * @group helpers
 */
class LoggerUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testShorten()
    {
        $name = 'org\\apache\\logging\\log4php\\Foo';

        $actual = Utils::shortenClassName($name, null);
        self::assertSame($name, $actual);

        $actual = Utils::shortenClassName($name, 0);
        self::assertSame('Foo', $actual);

        $actual = Utils::shortenClassName($name, 5);
        self::assertSame('o\\a\\l\\l\\Foo', $actual);

        $actual = Utils::shortenClassName($name, 16);
        self::assertSame('o\\a\\l\\l\\Foo', $actual);

        $actual = Utils::shortenClassName($name, 17);
        self::assertSame('o\\a\\l\\log4php\\Foo', $actual);

        $actual = Utils::shortenClassName($name, 25);
        self::assertSame('o\\a\\logging\\log4php\\Foo', $actual);

        $actual = Utils::shortenClassName($name, 28);
        self::assertSame('o\\apache\\logging\\log4php\\Foo', $actual);

        $actual = Utils::shortenClassName($name, 30);
        self::assertSame('org\\apache\\logging\\log4php\\Foo', $actual);
    }

    /** Dot separated notation must be supported for legacy reasons. */
    public function testShortenWithDots()
    {
        $name = 'org.apache.logging.log4php.Foo';

        $actual = Utils::shortenClassName($name, null);
        self::assertSame($name, $actual);

        $actual = Utils::shortenClassName($name, 0);
        self::assertSame('Foo', $actual);

        $actual = Utils::shortenClassName($name, 5);
        self::assertSame('o\a\l\l\Foo', $actual);

        $actual = Utils::shortenClassName($name, 16);
        self::assertSame('o\a\l\l\Foo', $actual);

        $actual = Utils::shortenClassName($name, 17);
        self::assertSame('o\a\l\log4php\Foo', $actual);

        $actual = Utils::shortenClassName($name, 25);
        self::assertSame('o\a\logging\log4php\Foo', $actual);

        $actual = Utils::shortenClassName($name, 28);
        self::assertSame('o\apache\logging\log4php\Foo', $actual);

        $actual = Utils::shortenClassName($name, 30);
        self::assertSame('org\apache\logging\log4php\Foo', $actual);
    }

}