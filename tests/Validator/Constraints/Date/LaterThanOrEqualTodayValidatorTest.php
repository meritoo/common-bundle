<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Validator\Constraints\Date;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Test\Validator\Date\BaseThanTodayValidatorTestCase;
use Meritoo\CommonBundle\Validator\Constraints\Date\LaterThanOrEqualToday;
use Meritoo\CommonBundle\Validator\Constraints\Date\LaterThanOrEqualTodayValidator;

/**
 * Test case for the validator of date that should be later than or equal today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Validator\Constraints\Date\LaterThanOrEqualTodayValidator
 */
class LaterThanOrEqualTodayValidatorTest extends BaseThanTodayValidatorTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(LaterThanOrEqualTodayValidator::class);
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
     * @param \DateTime $value The date to validate
     * @dataProvider provideNotWholeDayEarlierDate
     */
    public function testValidateUsingNotWholeDayEarlierDate(\DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * @param \DateTime $value The date to validate
     * @dataProvider provideEarlierDate
     */
    public function testValidateUsingEarlierDate(\DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this
            ->buildViolation('meritoo_common.date.later_than_or_equal_today')
            ->assertRaised()
        ;
    }

    /**
     * @param \DateTime $value The date to validate
     * @dataProvider provideNotWholeDayLaterDate
     */
    public function testValidateUsingNotWholeDayLaterDate(\DateTime $value): void
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
            ->validate(new \DateTime(), static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * @param \DateTime $value The date to validate
     * @dataProvider provideLaterDate
     */
    public function testValidateUsingLaterDate(\DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createValidator(): LaterThanOrEqualTodayValidator
    {
        return new LaterThanOrEqualTodayValidator();
    }

    /**
     * Returns constraint used by validator
     *
     * @return LaterThanOrEqualToday
     */
    private static function getConstraint(): LaterThanOrEqualToday
    {
        return new LaterThanOrEqualToday();
    }
}
