<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Validator\Constraints\Date;

use Symfony\Component\Validator\Constraint;

/**
 * Base constraint of date that should be compared to today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseThanTodayConstraint extends Constraint
{
    /**
     * The error message
     *
     * @var string
     */
    public string $message = '';
}
