<?php

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Pagination;

use Meritoo\Common\Enums\OopVisibility;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectCurrentPageException;

/**
 * Test case of an exception used while the "current page" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectCurrentPageException
 */
class IncorrectCurrentPageExceptionTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            IncorrectCurrentPageException::class,
            OopVisibility::Public,
            1,
            1,
        );
    }

    public function testCreate(): void
    {
        $exception = new IncorrectCurrentPageException(0);

        static::assertSame(
            'The \'current page\' parameter of pagination should be greater than 0, but 0 was provided. Is there'
            .' everything ok?',
            $exception->getMessage(),
        );
    }
}
