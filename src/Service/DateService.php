<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use DateTimeInterface;
use Exception;
use IntlDateFormatter;
use Meritoo\CommonBundle\Enums\Date\DateLength;
use Meritoo\CommonBundle\Service\Base\BaseService;

/**
 * Serves dates
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DateService extends BaseService
{
    /**
     * Format of date without time
     *
     * @var string
     */
    private string $dateFormat;

    /**
     * Format of date with time
     *
     * @var string
     */
    private string $dateTimeFormat;

    /**
     * Format of time without date
     *
     * @var string
     */
    private string $timeFormat;

    /**
     * Class constructor
     *
     * @param string $dateFormat Format of date without time
     * @param string $dateTimeFormat Format of date with time
     * @param string $timeFormat Format of time without date
     */
    public function __construct(string $dateFormat, string $dateTimeFormat, string $timeFormat)
    {
        $this->dateFormat = $dateFormat;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->timeFormat = $timeFormat;
    }

    /**
     * Returns date formatted according to given length of date
     *
     * @param DateTimeInterface $dateTime The date to format
     * @param DateLength $dateLength Type of date length
     *
     * @return string
     */
    public function formatDate(DateTimeInterface $dateTime, DateLength $dateLength): string
    {
        $format = $this->getFormat($dateLength);

        return $dateTime->format($format);
    }

    /**
     * Returns given date formatted with format based on locale.
     * Uses the \IntlDateFormatter class to set proper type / length of date and time part in the returned string.
     *
     * @param int $dateType Type/length of date part in the returned string. One of constants of the
     * \IntlDateFormatter class, e.g. \IntlDateFormatter::SHORT.
     * @param int $timeType Type/length of time part in the returned string. One of constants of the
     * \IntlDateFormatter class, e.g. \IntlDateFormatter::MEDIUM.
     * @param string $locale Locale used to format given date
     * @param DateTimeInterface $dateTime The date to format
     *
     * @return string
     * @throws Exception
     */
    public function formatDateUsingLocale(
        int $dateType,
        int $timeType,
        string $locale,
        DateTimeInterface $dateTime,
    ): string {
        $timestamp = $dateTime->getTimestamp();

        return (new IntlDateFormatter($locale, $dateType, $timeType))->format($timestamp);
    }

    /**
     * Returns format of date according to given length of date
     *
     * @param DateLength $dateLength Type of date length
     *
     * @return string
     */
    public function getFormat(DateLength $dateLength): string
    {
        $format = '';

        switch ($dateLength) {
            case DateLength::Date:
                $format = $this->dateFormat;

                break;
            case DateLength::DateTime:
                $format = $this->dateTimeFormat;

                break;
            case DateLength::Time:
                $format = $this->timeFormat;

                break;
        }

        return $format;
    }
}
