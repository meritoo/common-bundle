<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Application;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\Common\ValueObject\Version;
use Meritoo\CommonBundle\Application\Descriptor;

/**
 * Test case of the descriptor of application
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DescriptorTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(Descriptor::class, OopVisibilityType::IS_PUBLIC, 3, 3);
    }

    /**
     * @param string       $name        Name of application
     * @param string       $description Description of application
     * @param Version|null $version     Version of application
     * @param Descriptor   $expected    Expected descriptor of application
     *
     * @dataProvider provideEmptyValuesForConstructor
     */
    public function testConstructorUsingEmptyValues(
        string $name,
        string $description,
        ?Version $version,
        Descriptor $expected
    ): void {
        $descriptor = new Descriptor($name, $description, $version);
        static::assertEquals($expected, $descriptor);
    }

    /**
     * @param Descriptor   $descriptor Descriptor of application
     * @param Version|null $expected   Expected version of application
     *
     * @dataProvider provideDescriptorAndVersion
     */
    public function testGetVersion(Descriptor $descriptor, ?Version $expected): void
    {
        static::assertEquals($expected, $descriptor->getVersion());
    }

    /**
     * @param Descriptor $descriptor Descriptor of application
     * @param string     $expected   Expected name of application
     *
     * @dataProvider provideDescriptorAndName
     */
    public function testGetName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getName());
    }

    /**
     * @param Descriptor $descriptor Descriptor of application
     * @param string     $expected   Expected description of application
     *
     * @dataProvider provideDescriptorAndDescription
     */
    public function testGetDescription(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getDescription());
    }

    /**
     * @param Descriptor $descriptor Descriptor of application
     * @param string     $expected   Expected string representation of descriptor
     *
     * @dataProvider provideDescriptorAsString
     * @covers       \Meritoo\CommonBundle\Application\Descriptor::__toString
     */
    public function testToString(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, (string)$descriptor);
    }

    /**
     * Provides empty values for constructor and expected descriptor
     *
     * @return Generator
     */
    public function provideEmptyValuesForConstructor(): Generator
    {
        yield[
            '',
            '',
            null,
            new Descriptor('', '', null),
        ];

        yield[
            '0',
            '0',
            null,
            new Descriptor('0', '0', null),
        ];
    }

    /**
     * Provides descriptor and version of application
     *
     * @return Generator
     */
    public function provideDescriptorAndVersion(): Generator
    {
        yield[
            new Descriptor('', '', null),
            null,
        ];

        yield[
            new Descriptor('', '', new Version(1, 0, 2)),
            new Version(1, 0, 2),
        ];

        yield[
            new Descriptor('Pharetra', '', new Version(0, 10, 134)),
            new Version(0, 10, 134),
        ];

        yield[
            new Descriptor('Inceptos', 'Donec id elit non mi porta gravida at eget metus', new Version(0, 10, 134)),
            new Version(0, 10, 134),
        ];
    }

    /**
     * Provides descriptor and name of application
     *
     * @return Generator
     */
    public function provideDescriptorAndName(): Generator
    {
        yield[
            new Descriptor('', '', new Version(1, 0, 2)),
            '',
        ];

        yield[
            new Descriptor('Pharetra', '', new Version(0, 10, 134)),
            'Pharetra',
        ];

        yield[
            new Descriptor('Inceptos', 'Donec id elit non mi porta gravida at eget metus', new Version(0, 10, 134)),
            'Inceptos',
        ];
    }

    /**
     * Provides descriptor and description of application
     *
     * @return Generator
     */
    public function provideDescriptorAndDescription(): Generator
    {
        yield[
            new Descriptor('', '', new Version(1, 0, 2)),
            '',
        ];

        yield[
            new Descriptor('Pharetra', '', new Version(0, 10, 134)),
            '',
        ];

        yield[
            new Descriptor('Inceptos', 'Donec id elit non mi porta gravida at eget metus', new Version(0, 10, 134)),
            'Donec id elit non mi porta gravida at eget metus',
        ];
    }

    /**
     * Provides descriptor as string and the instance of the descriptor
     *
     * @return Generator
     */
    public function provideDescriptorAsString(): ?Generator
    {
        yield[
            new Descriptor('', '', null),
            '- | - | -',
        ];

        yield[
            new Descriptor('Ultricies', '', null),
            'Ultricies | - | -',
        ];

        yield[
            new Descriptor('Ultricies', 'Nullam quis risus eget urna mollis ornare vel eu leo', null),
            'Ultricies | Nullam quis risus eget urna mollis ornare vel eu leo | -',
        ];

        yield[
            new Descriptor(
                'Ultricies',
                'Nullam quis risus eget urna mollis ornare vel eu leo',
                new Version(10, 99, 73)
            ),
            'Ultricies | Nullam quis risus eget urna mollis ornare vel eu leo | 10.99.73',
        ];

        yield[
            new Descriptor(
                '',
                'Nullam quis risus eget urna mollis ornare vel eu leo',
                new Version(10, 99, 73)
            ),
            '- | Nullam quis risus eget urna mollis ornare vel eu leo | 10.99.73',
        ];

        yield[
            new Descriptor(
                '',
                'Nullam quis risus eget urna mollis ornare vel eu leo',
                new Version(10, 99, 73)
            ),
            '- | Nullam quis risus eget urna mollis ornare vel eu leo | 10.99.73',
        ];
    }
}
