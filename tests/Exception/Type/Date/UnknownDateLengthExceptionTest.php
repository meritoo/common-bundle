<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Type\Date;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\Common\Utilities\Arrays;
use Meritoo\CommonBundle\Exception\Type\Date\UnknownDateLengthException;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;
use Meritoo\CommonBundle\Type\Date\DateLength;

/**
 * Class UnknownDateLengthExceptionTest
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Exception\Type\Date\UnknownDateLengthException
 */
class UnknownDateLengthExceptionTest extends BaseTestCase
{
    public function testConstructorVisibilityAndArguments(): void
    {
        static::assertConstructorVisibilityAndArguments(
            UnknownConfigurationFileTypeException::class,
            OopVisibilityType::IS_PUBLIC,
            3
        );
    }

    /**
     * @param string $description     Description of test
     * @param string $unknownType     Unknown type of date length for date format
     * @param string $expectedMessage Expected message of exception
     *
     * @dataProvider provideUnknownTypeAndMessage
     */
    public function testCreateException(string $description, string $unknownType, string $expectedMessage): void
    {
        $exception = UnknownDateLengthException::createException($unknownType);
        static::assertSame($expectedMessage, $exception->getMessage(), $description);
    }

    public function provideUnknownTypeAndMessage(): ?Generator
    {
        $template = 'The \'%s\' type of %s is unknown. Probably doesn\'t exist or there is a typo. You should use one'
            . ' of these types: %s.';

        $allTypes = (new DateLength())->getAll();
        $types = Arrays::values2string($allTypes, '', ', ');

        yield[
            'An empty string',
            '',
            sprintf($template, '', 'date length for date format', $types),
        ];

        yield[
            'Strange type 1',
            'xyz ;asdkq28h',
            sprintf($template, 'xyz ;asdkq28h', 'date length for date format', $types),
        ];

        yield[
            'Strange type 2',
            ' _ & #---# ++;;...',
            sprintf($template, ' _ & #---# ++;;...', 'date length for date format', $types),
        ];
    }
}
