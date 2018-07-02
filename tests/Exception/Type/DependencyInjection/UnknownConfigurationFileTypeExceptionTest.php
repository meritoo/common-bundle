<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Type\DependencyInjection;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;

/**
 * Test case of an exception used while type of Dependency Injection (DI) configuration file is unknown
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class UnknownConfigurationFileTypeExceptionTest extends BaseTestCase
{
    public function testConstructorVisibilityAndArguments(): void
    {
        static::assertConstructorVisibilityAndArguments(UnknownConfigurationFileTypeException::class, OopVisibilityType::IS_PUBLIC, 3);
    }

    /**
     * @param string $unknownType     Unknown type of Dependency Injection (DI) configuration file
     * @param string $expectedMessage Expected message of exception
     *
     * @dataProvider provideUnknownTypeAndMessage
     */
    public function testCreateException(string $unknownType, string $expectedMessage): void
    {
        $exception = UnknownConfigurationFileTypeException::createException($unknownType);

        static::assertInstanceOf(UnknownConfigurationFileTypeException::class, $exception);
        static::assertSame($expectedMessage, $exception->getMessage());
    }

    /**
     * Provides unknown type and message of exception
     *
     * @return Generator
     */
    public function provideUnknownTypeAndMessage(): Generator
    {
        $template = 'The \'%s\' type of Dependency Injection (DI) configuration file is unknown. Probably doesn\'t'
            . ' exist or there is a typo. You should use one of these types: php, xml, yaml.';

        yield[
            '',
            sprintf($template, ''),
        ];

        yield[
            'jpg',
            sprintf($template, 'jpg'),
        ];

        yield[
            'txt',
            sprintf($template, 'txt'),
        ];

        yield[
            'yml',
            sprintf($template, 'yml'),
        ];
    }
}
