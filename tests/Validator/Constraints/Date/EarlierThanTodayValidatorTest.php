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
use Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanToday;
use Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanTodayValidator;

/**
 * Test case for the validator of date that should be earlier than today
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Validator\Constraints\Date\EarlierThanTodayValidator
 */
class EarlierThanTodayValidatorTest extends BaseThanTodayValidatorTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(EarlierThanTodayValidator::class);
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

        $this
            ->buildViolation('meritoo_common.date.earlier_than_today')
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
            ->validate($value, static::getConstraint())
        ;

        $this->assertNoViolation();
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

        $this
            ->buildViolation('meritoo_common.date.earlier_than_today')
            ->assertRaised()
        ;
    }

    public function testValidateUsingTodayDate(): void
    {
        $this
            ->validator
            ->validate(new \DateTime(), static::getConstraint())
        ;

        $this
            ->buildViolation('meritoo_common.date.earlier_than_today')
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
            ->validate($value, static::getConstraint())
        ;

        $this
            ->buildViolation('meritoo_common.date.earlier_than_today')
            ->assertRaised()
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function createValidator(): EarlierThanTodayValidator
    {
        return new EarlierThanTodayValidator();
    }

    /**
     * Returns constraint used by validator
     *
     * @return EarlierThanToday
     */
    private static function getConstraint(): EarlierThanToday
    {
        return new EarlierThanToday();
    }
}
