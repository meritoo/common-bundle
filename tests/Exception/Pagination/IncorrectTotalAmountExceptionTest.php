<?php

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Pagination;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectTotalAmountException;

/**
 * Test case of an exception used while the "total amount" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectTotalAmountException
 */
class IncorrectTotalAmountExceptionTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            IncorrectTotalAmountException::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testCreate(): void
    {
        $exception = new IncorrectTotalAmountException(-1);

        static::assertSame(
            'The \'total amount\' parameter of pagination should be greater than or equal 0, but -1 was'
            . ' provided. Is there everything ok?',
            $exception->getMessage()
        );
    }
}
