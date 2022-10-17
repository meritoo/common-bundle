<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Validator\Constraints\Date;

/**
 * The "date later than or equal today" constraint
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @Annotation
 */
class LaterThanOrEqualToday extends BaseThanTodayConstraint
{
    /**
     * {@inheritDoc}
     */
    public string $message = 'meritoo_common.date.later_than_or_equal_today';
}
