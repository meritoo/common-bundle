<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Validator\Constraints\Date;

use DateTime;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Test\Validator\Date\BaseThanTodayValidatorTestCase;
use Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanOrEqualToday;
use Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanOrEqualTodayValidator;

/**
 * Test case for the validator of date that should be earlier than or equal today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanOrEqualTodayValidator
 */
class EarlierThanOrEqualTodayValidatorTest extends BaseThanTodayValidatorTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(EarlierThanOrEqualTodayValidator::class);
    }

    /**
     * @param DateTime $value The date to validate
     * @dataProvider provideEarlierDate
     */
    public function testValidateUsingEarlierDate(DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * @param mixed $value An empty value
     * @dataProvider provideEmptyValue
     */
    public function testValidateUsingEmptyValues($value): void
    {
        $this->validator->validate($value, static::getConstraint());
        $this->assertNoViolation();
    }

    /**
     * @param DateTime $value The date to validate
     * @dataProvider provideLaterDate
     */
    public function testValidateUsingLaterDate(DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this
            ->buildViolation('meritoo_common.date.earlier_than_or_equal_today')
            ->assertRaised()
        ;
    }

    /**
     * @param DateTime $value The date to validate
     * @dataProvider provideNotWholeDayEarlierDate
     */
    public function testValidateUsingNotWholeDayEarlierDate(DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * @param DateTime $value The date to validate
     * @dataProvider provideNotWholeDayLaterDate
     */
    public function testValidateUsingNotWholeDayLaterDate(DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    public function testValidateUsingTodayDate(): void
    {
        $this
            ->validator
            ->validate(new DateTime(), static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createValidator(): EarlierThanOrEqualTodayValidator
    {
        return new EarlierThanOrEqualTodayValidator();
    }

    /**
     * Returns constraint used by validator
     *
     * @return EarlierThanOrEqualToday
     */
    private static function getConstraint(): EarlierThanOrEqualToday
    {
        return new EarlierThanOrEqualToday();
    }
}
