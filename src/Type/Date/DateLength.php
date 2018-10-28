<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Meritoo\CommonBundle\Type\Date;

use Meritoo\Common\Type\Base\BaseType;

/**
 * Type of date length for date format
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DateLength extends BaseType
{
    /**
     * The "date" length.
     * Date without time.
     *
     * @var string
     */
    public const DATE = 'date';

    /**
     * The "datetime" length.
     * Date with time.
     *
     * @var string
     */
    public const DATETIME = 'datetime';

    /**
     * The "time" length.
     * Time only, without date.
     *
     * @var string
     */
    public const TIME = 'time';
}
