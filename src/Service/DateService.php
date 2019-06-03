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
use Meritoo\CommonBundle\Exception\Type\Date\UnknownDateLengthException;
use Meritoo\CommonBundle\Service\Base\BaseService;
use Meritoo\CommonBundle\Type\Date\DateLength;

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
    private $dateFormat;

    /**
     * Format of date with time
     *
     * @var string
     */
    private $dateTimeFormat;

    /**
     * Format of time without date
     *
     * @var string
     */
    private $timeFormat;

    /**
     * Class constructor
     *
     * @param string $dateFormat     Format of date without time
     * @param string $dateTimeFormat Format of date with time
     * @param string $timeFormat     Format of time without date
     */
    public function __construct(string $dateFormat, string $dateTimeFormat, string $timeFormat)
    {
        $this->dateFormat = $dateFormat;
        $this->dateTimeFormat = $dateTimeFormat;
        $this->timeFormat = $timeFormat;
    }

    /**
     * Returns format of date according to given length of date
     *
     * @param string $dateLength Type of date length. One of the DateLength's class constants.
     * @throws UnknownDateLengthException
     * @return string
     */
    public function getFormat(string $dateLength): string
    {
        // Oops, unknown length of date
        if (false === DateLength::isCorrectType($dateLength)) {
            throw UnknownDateLengthException::createException($dateLength);
        }

        $format = '';

        switch ($dateLength) {
            case DateLength::DATE:
                $format = $this->dateFormat;

                break;
            case DateLength::DATETIME:
                $format = $this->dateTimeFormat;

                break;
            case DateLength::TIME:
                $format = $this->timeFormat;

                break;
        }

        return $format;
    }

    /**
     * Returns date formatted according to given length of date
     *
     * @param DateTimeInterface $dateTime   The date to format
     * @param string             $dateLength Type of date length. One of the DateLength's class constants.
     * @return string
     */
    public function formatDate(DateTimeInterface $dateTime, string $dateLength): string
    {
        $format = $this->getFormat($dateLength);

        return $dateTime->format($format);
    }

    /**
     * Returns given date formatted with format based on locale.
     * Uses the \IntlDateFormatter class to set proper type / length of date and time part in the returned string.
     *
     * @param int                $dateType Type/length of date part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::SHORT.
     * @param int                $timeType Type/length of time part in the returned string. One of constants of the
     *                                     \IntlDateFormatter class, e.g. \IntlDateFormatter::MEDIUM.
     * @param string             $locale   Locale used to format given date
     * @param DateTimeInterface $dateTime The date to format
     * @throws Exception
     * @return string
     */
    public function formatDateUsingLocale(
        int $dateType,
        int $timeType,
        string $locale,
        DateTimeInterface $dateTime
    ): string {
        $timestamp = $dateTime->getTimestamp();
        $formatter = new IntlDateFormatter($locale, $dateType, $timeType);

        return $formatter->format($timestamp);
    }
}
