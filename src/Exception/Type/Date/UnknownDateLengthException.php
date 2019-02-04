<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Type\Date;

use Meritoo\Common\Exception\Base\UnknownTypeException;
use Meritoo\CommonBundle\Type\Date\DateLength;

/**
 * An exception used while type of date length for date format is unknown
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class UnknownDateLengthException extends UnknownTypeException
{
    /**
     * Creates exception
     *
     * @param string $unknownType Unknown type of date length for date format
     * @return UnknownDateLengthException
     */
    public static function createException(string $unknownType): UnknownDateLengthException
    {
        /** @var UnknownDateLengthException $exception */
        $exception = static::create($unknownType, new DateLength(), 'date length for date format');

        return $exception;
    }
}
