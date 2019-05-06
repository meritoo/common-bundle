<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Test\Validator\Date;

use DateInterval;
use DateTime;
use Generator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * Base test case for the validator of date that should be compared to today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseThanTodayValidatorTestCase extends ConstraintValidatorTestCase
{
    /**
     * Provides not whole day earlier date
     *
     * @return Generator
     */
    public function provideNotWholeDayEarlierDate(): Generator
    {
        yield[
            (new DateTime())->sub(new DateInterval('PT1M')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('PT10M')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('PT1S')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('PT10S')),
        ];
    }

    /**
     * Provides earlier date
     *
     * @return Generator
     */
    public function provideEarlierDate(): Generator
    {
        yield[
            (new DateTime())->sub(new DateInterval('P1W')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('P10W')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('P1M')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('P10M')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('P1D')),
        ];

        yield[
            (new DateTime())->sub(new DateInterval('P10D')),
        ];
    }

    /**
     * Provides not whole day later date
     *
     * @return Generator
     */
    public function provideNotWholeDayLaterDate(): Generator
    {
        yield[
            (new DateTime())->add(new DateInterval('PT1M')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('PT10M')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('PT1S')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('PT10S')),
        ];
    }

    /**
     * Provides later date
     *
     * @return Generator
     */
    public function provideLaterDate(): Generator
    {
        yield[
            (new DateTime())->add(new DateInterval('P1W')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('P10W')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('P1M')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('P10M')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('P1D')),
        ];

        yield[
            (new DateTime())->add(new DateInterval('P10D')),
        ];
    }
}
