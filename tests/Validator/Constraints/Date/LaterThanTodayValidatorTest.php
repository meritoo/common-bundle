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
use Meritoo\CommonBundle\Validator\Constraints\Date\LaterThanToday;
use Meritoo\CommonBundle\Validator\Constraints\Date\LaterThanTodayValidator;

/**
 * Test case for the validator of date that should be later than today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class LaterThanTodayValidatorTest extends BaseThanTodayValidatorTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(LaterThanTodayValidator::class);
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
            ->validate($value, static::getConstraint());

        $this
            ->buildViolation('meritoo_common.date.later_than_today')
            ->assertRaised()
        ;
    }

    /**
     * @param \DateTime $value The date to validate
     * @dataProvider provideEarlierDate
     */
    public function testValidateUsingEarlierDate(\DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint());

        $this
            ->buildViolation('meritoo_common.date.later_than_today')
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
            ->validate($value, static::getConstraint());

        $this
            ->buildViolation('meritoo_common.date.later_than_today')
            ->assertRaised()
        ;
    }

    public function testValidateUsingTodayDate(): void
    {
        $this
            ->validator
            ->validate(new \DateTime(), static::getConstraint());

        $this
            ->buildViolation('meritoo_common.date.later_than_today')
            ->assertRaised()
        ;
    }

    /**
     * @param \DateTime $value The date to validate
     * @dataProvider provideLaterDate
     */
    public function testValidateUsingLaterDate(\DateTime $value): void
    {
        $this
            ->validator
            ->validate($value, static::getConstraint());

        $this->assertNoViolation();
    }

    /**
     * {@inheritdoc}
     */
    protected function createValidator(): LaterThanTodayValidator
    {
        return new LaterThanTodayValidator();
    }

    /**
     * Returns constraint used by validator
     *
     * @return LaterThanToday
     */
    private static function getConstraint(): LaterThanToday
    {
        return new LaterThanToday();
    }
}
