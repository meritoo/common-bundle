<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle;

use PHPUnit\Framework\TestCase;

/**
 * Dummy Test
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DummyTest extends TestCase
{
    public function testEquality(): void
    {
        static::assertEquals(1, 1);
    }
}
