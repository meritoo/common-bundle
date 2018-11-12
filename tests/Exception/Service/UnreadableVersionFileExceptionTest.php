<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Service;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\Service\ApplicationService\UnreadableVersionFileException;

/**
 * Test case of an exception used while file, who contains version of the application, is not readable
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class UnreadableVersionFileExceptionTest extends BaseTestCase
{
    public function testConstructorVisibilityAndArguments(): void
    {
        static::assertConstructorVisibilityAndArguments(UnreadableVersionFileException::class, OopVisibilityType::IS_PUBLIC, 3);
    }

    /**
     * @param string $filePath        Path of a file who contains version of the application
     * @param string $expectedMessage Expected message of exception
     *
     * @dataProvider provideFilePathAndMessage
     */
    public function testCreate(string $filePath, string $expectedMessage): void
    {
        $exception = UnreadableVersionFileException::create($filePath);

        static::assertInstanceOf(UnreadableVersionFileException::class, $exception);
        static::assertSame($expectedMessage, $exception->getMessage());
    }

    /**
     * Provides path of a file and message of exception
     *
     * @return Generator
     */
    public function provideFilePathAndMessage(): Generator
    {
        $template = 'File %s, who contains version of the application, is not readable. Does the file exist?';

        yield[
            '',
            sprintf($template, ''),
        ];

        yield[
            'abc',
            sprintf($template, 'abc'),
        ];

        yield[
            'purus/sit/cum/et/dis/mus',
            sprintf($template, 'purus/sit/cum/et/dis/mus'),
        ];
    }
}
