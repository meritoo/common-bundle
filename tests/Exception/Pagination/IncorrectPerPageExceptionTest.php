<?php

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Pagination;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectPerPageException;

/**
 * Test case of an exception used while the "per page" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectPerPageException
 */
class IncorrectPerPageExceptionTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            IncorrectPerPageException::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testCreate(): void
    {
        $exception = new IncorrectPerPageException(0);

        static::assertSame(
            'The \'per page\' parameter of pagination should be greater than 0, but 0 was provided. Is there'
            . ' everything ok?',
            $exception->getMessage()
        );
    }
}
