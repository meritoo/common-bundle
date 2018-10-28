<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\Type\Date\UnknownDateLengthException;
use Meritoo\CommonBundle\Service\DateService;
use Meritoo\CommonBundle\Type\Date\DateLength;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the service that serves dates
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DateServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            DateService::class,
            OopVisibilityType::IS_PUBLIC,
            3,
            3
        );
    }

    /**
     * @param string $dateLength Unknown type of date length
     * @dataProvider provideUnknownDateLength
     */
    public function testFormatDateUsingUnknownDateLength(string $dateLength): void
    {
        $this->expectException(UnknownDateLengthException::class);

        static::$container
            ->get(DateService::class)
            ->formatDate(new \DateTime(), $dateLength);
    }

    /**
     * @param \DateTimeInterface $dateTime   The date to format
     * @param string             $dateLength Type of date length
     * @param string             $expected   Expected date
     *
     * @dataProvider provideDateFormattedUsingDefaults
     */
    public function testFormatDateUsingDefaults(
        \DateTimeInterface $dateTime,
        string $dateLength,
        string $expected
    ): void {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $formatted = static::$container
            ->get(DateService::class)
            ->formatDate($dateTime, $dateLength);

        static::assertSame($expected, $formatted);
    }

    /**
     * @param \DateTimeInterface $dateTime   The date to format
     * @param string             $dateLength Type of date length
     * @param string             $expected   Expected date
     *
     * @dataProvider provideDateFormattedUsingTestEnvironment
     */
    public function testFormatDateUsingTestEnvironment(
        \DateTimeInterface $dateTime,
        string $dateLength,
        string $expected
    ): void {
        $formatted = static::$container
            ->get(DateService::class)
            ->formatDate($dateTime, $dateLength);

        static::assertSame($expected, $formatted);
    }

    /**
     * @param string $dateLength Unknown type of date length
     * @dataProvider provideUnknownDateLength
     */
    public function testGetFormatUsingUnknownDateLength(string $dateLength): void
    {
        $this->expectException(UnknownDateLengthException::class);

        static::$container
            ->get(DateService::class)
            ->getFormat($dateLength);
    }

    /**
     * @param string $dateLength Type of date length
     * @param string $expected   Expected date format
     *
     * @dataProvider provideDateFormatUsingDefaults
     */
    public function testGetFormatUsingDefaults(
        string $dateLength,
        string $expected
    ): void {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $format = static::$container
            ->get(DateService::class)
            ->getFormat($dateLength);

        static::assertSame($expected, $format);
    }

    /**
     * @param string $dateLength Type of date length
     * @param string $expected   Expected date format
     *
     * @dataProvider provideDateFormatUsingTestEnvironment
     */
    public function testGetFormatUsingTestEnvironment(
        string $dateLength,
        string $expected
    ): void {
        $format = static::$container
            ->get(DateService::class)
            ->getFormat($dateLength);

        static::assertSame($expected, $format);
    }

    /**
     * @param int                $dateType Type/length of date part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::SHORT.
     * @param int                $timeType Type/length of time part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::MEDIUM.
     * @param string             $locale   Locale used to format given date
     * @param \DateTimeInterface $dateTime The date to format
     * @param string             $expected Expected date
     *
     * @dataProvider provideDateFormattedUsingLocale
     */
    public function testFormatDateUsingLocaleAndDefaults(
        int $dateType,
        int $timeType,
        string $locale,
        \DateTimeInterface $dateTime,
        string $expected
    ): void {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $formatted = static::$container
            ->get(DateService::class)
            ->formatDateUsingLocale(
                $dateType,
                $timeType,
                $locale,
                $dateTime
            );

        static::assertSame($expected, $formatted);
    }

    /**
     * @param int                $dateType Type/length of date part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::SHORT.
     * @param int                $timeType Type/length of time part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::MEDIUM.
     * @param string             $locale   Locale used to format given date
     * @param \DateTimeInterface $dateTime The date to format
     * @param string             $expected Expected date
     *
     * @dataProvider provideDateFormattedUsingLocale
     */
    public function testFormatDateUsingLocaleAndTestEnvironment(
        int $dateType,
        int $timeType,
        string $locale,
        \DateTimeInterface $dateTime,
        string $expected
    ): void {
        $formatted = static::$container
            ->get(DateService::class)
            ->formatDateUsingLocale(
                $dateType,
                $timeType,
                $locale,
                $dateTime
            );

        static::assertSame($expected, $formatted);
    }

    /**
     * Provide unknown date length
     *
     * @return \Generator
     */
    public function provideUnknownDateLength(): \Generator
    {
        yield[
            '',
        ];

        yield[
            'xyz',
        ];

        yield[
            '0',
        ];

        yield[
            '1',
        ];

        yield[
            '-1',
        ];

        yield[
            0,
        ];

        yield[
            1,
        ];

        yield[
            -1,
        ];
    }

    /**
     * Provide date, date length and date formatted using default values
     *
     * @return \Generator
     */
    public function provideDateFormattedUsingDefaults(): \Generator
    {
        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::DATE,
            '01.02.1900',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::DATE,
            '15.10.2000',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::DATE,
            '01.05.2100',
        ];

        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::DATETIME,
            '01.02.1900 08:25',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::DATETIME,
            '15.10.2000 10:05',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::DATETIME,
            '01.05.2100 00:00',
        ];

        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::TIME,
            '08:25',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::TIME,
            '10:05',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::TIME,
            '00:00',
        ];
    }

    /**
     * Provide date, date length and date formatted using test environment
     *
     * @return \Generator
     */
    public function provideDateFormattedUsingTestEnvironment(): \Generator
    {
        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::DATE,
            '1900.02.01',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::DATE,
            '2000.10.15',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::DATE,
            '2100.05.01',
        ];

        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::DATETIME,
            '1900.02.01 08:25:40',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::DATETIME,
            '2000.10.15 10:05:40',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::DATETIME,
            '2100.05.01 00:00:00',
        ];

        yield[
            new \DateTime('01-02-1900 08:25:40'),
            DateLength::TIME,
            '08:25:40',
        ];

        yield[
            new \DateTime('2000-10-15 10:05:40'),
            DateLength::TIME,
            '10:05:40',
        ];

        yield[
            new \DateTime('2100-05-01'),
            DateLength::TIME,
            '00:00:00',
        ];
    }

    /**
     * Provide date format using default values
     *
     * @return \Generator
     */
    public function provideDateFormatUsingDefaults(): \Generator
    {
        yield[
            DateLength::DATE,
            'd.m.Y',
        ];

        yield[
            DateLength::DATETIME,
            'd.m.Y H:i',
        ];

        yield[
            DateLength::TIME,
            'H:i',
        ];
    }

    /**
     * Provide date format using test environment
     *
     * @return \Generator
     */
    public function provideDateFormatUsingTestEnvironment(): \Generator
    {
        yield[
            DateLength::DATE,
            'Y.m.d',
        ];

        yield[
            DateLength::DATETIME,
            'Y.m.d H:i:s',
        ];

        yield[
            DateLength::TIME,
            'H:i:s',
        ];
    }

    /**
     * Provide date formatted based on locale (and all required arguments)
     *
     * @return \Generator
     */
    public function provideDateFormattedUsingLocale(): \Generator
    {
        $locale = 'en_US';
        $dateString = '01-02-1900 08:25:40';

        /*
         * Without no valid:
         * - length of date
         * - length of time
         * - locale
         */
        yield[
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::NONE,
            '',
            new \DateTime($dateString),
            '19000201 08:25 AM',
        ];

        /*
         * Date only
         */
        yield[
            \IntlDateFormatter::SHORT,
            \IntlDateFormatter::NONE,
            $locale,
            new \DateTime($dateString),
            '2/1/00',
        ];

        yield[
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::NONE,
            $locale,
            new \DateTime($dateString),
            'Feb 1, 1900',
        ];

        yield[
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::NONE,
            $locale,
            new \DateTime($dateString),
            'February 1, 1900',
        ];

        /*
         * Time only
         */
        yield[
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            $locale,
            new \DateTime($dateString),
            'Thursday, February 1, 1900',
        ];

        yield[
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::SHORT,
            $locale,
            new \DateTime($dateString),
            '8:25 AM',
        ];

        yield[
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::MEDIUM,
            $locale,
            new \DateTime($dateString),
            '8:25:40 AM',
        ];

        yield[
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::LONG,
            $locale,
            new \DateTime($dateString),
            '8:25:40 AM GMT+1:24',
        ];

        yield[
            \IntlDateFormatter::NONE,
            \IntlDateFormatter::FULL,
            $locale,
            new \DateTime($dateString),
            '8:25:40 AM GMT+01:24',
        ];

        /*
         * Both, date & time
         */
        yield[
            \IntlDateFormatter::MEDIUM,
            \IntlDateFormatter::SHORT,
            $locale,
            new \DateTime($dateString),
            'Feb 1, 1900, 8:25 AM',
        ];

        yield[
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::MEDIUM,
            $locale,
            new \DateTime($dateString),
            'February 1, 1900 at 8:25:40 AM',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();

        date_default_timezone_set('Europe/Warsaw');
    }
}
