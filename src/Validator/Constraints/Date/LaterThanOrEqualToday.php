<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Validator\Constraints\Date;

use Symfony\Component\Validator\Constraint;

/**
 * The "date later than or equal today" constraint
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @Annotation
 */
class LaterThanOrEqualToday extends Constraint
{
    /**
     * The error message
     *
     * @var string
     */
    public $message = 'meritoo_common.date.later_than_or_equal_today';
}
