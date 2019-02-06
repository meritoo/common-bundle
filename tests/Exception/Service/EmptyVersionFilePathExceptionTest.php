<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Service;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\Service\ApplicationService\EmptyVersionFilePathException;

/**
 * Test case of an exception used while path of a file, who contains version of the application, is empty
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Exception\Service\ApplicationService\EmptyVersionFilePathException
 */
class EmptyVersionFilePathExceptionTest extends BaseTestCase
{
    public function testConstructorVisibilityAndArguments(): void
    {
        static::assertConstructorVisibilityAndArguments(EmptyVersionFilePathException::class, OopVisibilityType::IS_PUBLIC, 3);
    }

    public function testCreate(): void
    {
        $exception = EmptyVersionFilePathException::create();
        static::assertSame('Path of a file, who contains version of the application, is empty. Is there everything ok?', $exception->getMessage());
    }
}
