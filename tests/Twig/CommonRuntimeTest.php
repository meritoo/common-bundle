<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Generator;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Twig\CommonRuntime;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Test case for the runtime class related to CommonExtension Twig Extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\CommonRuntime
 */
class CommonRuntimeTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    /**
     * Provides value to check/filter if is empty, replacement of empty value and expected value
     *
     * @return Generator
     */
    public function provideValueAndValueReplacementToVerifyEmptyValue(): Generator
    {
        yield [
            null,
            '-',
            '-',
        ];

        yield [
            null,
            '|',
            '|',
        ];

        yield [
            [],
            '-',
            '-',
        ];

        yield [
            [],
            '~',
            '~',
        ];

        yield [
            '',
            '-',
            '-',
        ];

        yield [
            '',
            '.',
            '.',
        ];

        yield [
            'test',
            '-',
            'test',
        ];

        yield [
            '1234',
            '|',
            '1234',
        ];

        yield [
            1234,
            '~',
            1234,
        ];

        yield [
            [
                1234,
                'test',
            ],
            '.',
            [
                1234,
                'test',
            ],
        ];

        yield [
            $instance = new stdClass(),
            '---',
            $instance,
        ];
    }

    /**
     * Provides value to check/filter if is empty and expected value
     *
     * @return Generator
     */
    public function provideValueToVerifyEmptyValue(): Generator
    {
        yield [
            null,
            '...',
        ];

        yield [
            [],
            '...',
        ];

        yield [
            '',
            '...',
        ];

        yield [
            'test',
            'test',
        ];

        yield [
            '1234',
            '1234',
        ];

        yield [
            1234,
            1234,
        ];

        yield [
            [
                1234,
                'test',
            ],
            [
                1234,
                'test',
            ],
        ];

        yield [
            $instance = new stdClass(),
            $instance,
        ];
    }

    /**
     * Provides value to check/filter if is empty and expected value (using default configuration)
     *
     * @return Generator
     */
    public function provideValueToVerifyEmptyValueUsingDefaults(): Generator
    {
        yield [
            null,
            '-',
        ];

        yield [
            [],
            '-',
        ];

        yield [
            '',
            '-',
        ];

        yield [
            'test',
            'test',
        ];

        yield [
            '1234',
            '1234',
        ];

        yield [
            1234,
            1234,
        ];

        yield [
            [
                1234,
                'test',
            ],
            [
                1234,
                'test',
            ],
        ];

        yield [
            $instance = new stdClass(),
            $instance,
        ];
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            CommonRuntime::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testIsInstanceOfRuntimeExtensionInterface(): void
    {
        $runtime = static::getContainer()->get(CommonRuntime::class);
        static::assertInstanceOf(RuntimeExtensionInterface::class, $runtime);
    }

    /**
     * @param mixed       $value                 The value to check
     * @param null|string $emptyValueReplacement Custom replacement of empty value. If is set to null, the
     *                                           replacement is retrieved from configuration (default behaviour).
     * @param mixed       $expected              Expected value
     *
     * @dataProvider provideValueAndValueReplacementToVerifyEmptyValue
     */
    public function testVerifyEmptyValueUsingCustomValueReplacement(
        $value,
        ?string $emptyValueReplacement,
        $expected
    ): void {
        $verified = static::getContainer()
            ->get(CommonRuntime::class)
            ->verifyEmptyValue($value, $emptyValueReplacement)
        ;

        static::assertSame($expected, $verified);
    }

    /**
     * @param mixed $value    The value to check
     * @param mixed $expected Expected value
     *
     * @dataProvider provideValueToVerifyEmptyValueUsingDefaults
     */
    public function testVerifyEmptyValueUsingDefaults($value, $expected): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $verified = static::getContainer()
            ->get(CommonRuntime::class)
            ->verifyEmptyValue($value)
        ;

        static::assertSame($expected, $verified);
    }

    /**
     * @param mixed $value    The value to check
     * @param mixed $expected Expected value
     *
     * @dataProvider provideValueToVerifyEmptyValue
     */
    public function testVerifyEmptyValueUsingTestEnvironment($value, $expected): void
    {
        $verified = static::getContainer()
            ->get(CommonRuntime::class)
            ->verifyEmptyValue($value)
        ;

        static::assertSame($expected, $verified);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }
}
