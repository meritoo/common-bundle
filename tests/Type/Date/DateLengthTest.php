<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Type\Date;

use Meritoo\Common\Test\Base\BaseTypeTestCase;
use Meritoo\Common\Type\Base\BaseType;
use Meritoo\CommonBundle\Type\Date\DateLength;

/**
 * Test case for the type of date length for date format
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Type\Date\DateLength
 */
class DateLengthTest extends BaseTypeTestCase
{
    /**
     * {@inheritdoc}
     */
    public function provideTypeToVerify(): \Generator
    {
        yield[
            '',
            false,
        ];

        yield[
            null,
            false,
        ];

        yield[
            0,
            false,
        ];

        yield[
            1,
            false,
        ];

        yield[
            'date',
            true,
        ];

        yield[
            'datetime',
            true,
        ];

        yield[
            'time',
            true,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getAllExpectedTypes(): array
    {
        return [
            'DATE'     => DateLength::DATE,
            'DATETIME' => DateLength::DATETIME,
            'TIME'     => DateLength::TIME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getTestedTypeInstance(): BaseType
    {
        return new DateLength();
    }
}
