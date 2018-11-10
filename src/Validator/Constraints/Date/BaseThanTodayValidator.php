<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Validator\Constraints\Date;

use Meritoo\Common\Utilities\Date;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Base validator of date that should be compared to today
 *
 * Supported constraints:
 * - earlier than today
 * - later than today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseThanTodayValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        /*
         * Not a date?
         * Nothing to do
         */
        if (!Date::isValidDate($value)) {
            return;
        }

        $difference = $this->getDifference($value);

        /*
         * It's a valid date?
         * Nothing to do
         */
        if ($this->isValid($constraint, $difference)) {
            return;
        }

        $this
            ->context
            ->buildViolation($constraint->message)
            ->addViolation()
        ;
    }

    /**
     * Returns difference between validated date and today
     *
     * @param mixed $value Value to validate
     * @return int
     */
    private function getDifference($value): int
    {
        /*
         * Let's prepare the dates...
         */
        $now = (new \DateTime())->setTime(0, 0);
        $date = Date::getDateTime($value);

        /*
         * ...and make comparison with "day" as unit
         */

        return Date::getDateDifference($now, $date, Date::DATE_DIFFERENCE_UNIT_DAYS);
    }

    /**
     * Returns information if processing date is valid.
     * Based on given constraint and difference between the date and today.
     *
     * @param Constraint $constraint The constraint
     * @param int        $difference Difference between validated date and today
     * @return bool
     */
    private function isValid(Constraint $constraint, int $difference): bool
    {
        /*
         * It's a earlier than today date?
         * Nothing to do
         */
        if ($constraint instanceof EarlierThanToday && $difference < 0) {
            return true;
        }

        /*
         * It's a earlier than or equal today date?
         * Nothing to do
         */
        if ($constraint instanceof EarlierThanOrEqualToday && $difference <= 0) {
            return true;
        }

        /*
         * It's a later than today date?
         * Nothing to do
         */
        if ($constraint instanceof LaterThanToday && $difference > 0) {
            return true;
        }

        /*
         * It's a later than or equal today date?
         * Nothing to do
         */
        if ($constraint instanceof LaterThanOrEqualToday && $difference >= 0) {
            return true;
        }

        return false;
    }
}
