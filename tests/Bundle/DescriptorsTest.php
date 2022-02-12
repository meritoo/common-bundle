<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Bundle;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Bundle\Descriptor;
use Meritoo\CommonBundle\Bundle\Descriptors;

/**
 * Test case of the descriptors of bundles
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Bundle\Descriptors
 */
class DescriptorsTest extends BaseTestCase
{
    /**
     * Provides array with data of descriptors and the expected descriptors
     *
     * @return Generator
     */
    public function provideArrayForDescriptors(): Generator
    {
        $descriptors1 = new Descriptors();
        $descriptors1->addMultiple([
            new Descriptor(),
            new Descriptor(),
        ]);

        $descriptors2 = new Descriptors();
        $descriptors2->addMultiple([
            new Descriptor('Risus', 'Ridiculus'),
            new Descriptor('Sollicitudin', 'Vulputate'),
            new Descriptor(
                'Pellentesque',
                'Commodo',
                '',
                '',
                new Descriptor(
                    'Vulputate',
                    'Dolor'
                )
            ),
        ]);

        yield 'An empty array' => [
            [],
            new Descriptors(),
        ];

        yield 'Two empty descriptors' => [
            [
                [],
                [
                    'name' => '',
                    'configurationRootName' => '',
                ],
            ],
            $descriptors1,
        ];

        yield 'Two simple descriptors + one nested descriptor' => [
            [
                [
                    'name' => 'Risus',
                    'configurationRootName' => 'Ridiculus',
                ],
                [
                    'name' => 'Sollicitudin',
                    'configurationRootName' => 'Vulputate',
                    'parentBundleDescriptor' => [],
                ],
                [
                    'name' => 'Pellentesque',
                    'configurationRootName' => 'Commodo',
                    'parentBundleDescriptor' => [
                        'name' => 'Vulputate',
                        'configurationRootName' => 'Dolor',
                    ],
                ],
            ],
            $descriptors2,
        ];

        yield 'Descriptors with more details' => [
            [
                [
                    'name' => 'Risus',
                    'rootNamespace' => 'Petierunt\Uti\Sibi',
                    'configurationRootName' => 'Ridiculus',
                ],
                [
                    'name' => 'Sollicitudin',
                    'rootNamespace' => 'Concilium\Totius\Galliae',
                    'configurationRootName' => 'Vulputate',
                    'parentBundleDescriptor' => [],
                ],
                [
                    'name' => 'Pellentesque',
                    'rootNamespace' => 'Idque\Caesaris\Facere\Voluntate',
                    'configurationRootName' => 'Commodo',
                    'parentBundleDescriptor' => [
                        'name' => 'Vulputate',
                        'configurationRootName' => 'Dolor',
                    ],
                ],
            ],
            new Descriptors([
                new Descriptor('Risus', 'Ridiculus', 'Petierunt\Uti\Sibi'),
                new Descriptor('Sollicitudin', 'Vulputate', 'Concilium\Totius\Galliae'),
                new Descriptor(
                    'Pellentesque',
                    'Commodo',
                    'Idque\Caesaris\Facere\Voluntate',
                    '',
                    new Descriptor(
                        'Vulputate',
                        'Dolor'
                    )
                ),
            ]),
        ];
    }

    /**
     * Provides descriptors of bundles and an array representation of the descriptors
     *
     * @return Generator
     */
    public function provideArrayFromDescriptors(): Generator
    {
        yield 'An empty array' => [
            new Descriptors(),
            [],
        ];

        yield 'Two descriptors with names only' => [
            new Descriptors([
                new Descriptor('UnamIncolunt'),
                new Descriptor('ContraLegem'),
            ]),
            [
                0 => [
                    'name' => 'UnamIncolunt',
                    'shortName' => 'unamincolunt',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                1 => [
                    'name' => 'ContraLegem',
                    'shortName' => 'contralegem',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield 'Two not full descriptors' => [
            new Descriptors([
                new Descriptor('LigulaBundle', '', 'Ipsum\Ridiculus\Tellus', 'ipsum/ridiculus/tellus'),
                new Descriptor('', 'pharetra'),
            ]),
            [
                'Ipsum\Ridiculus\Tellus' => [
                    'name' => 'LigulaBundle',
                    'shortName' => 'ligula',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Ipsum\Ridiculus\Tellus',
                    'path' => 'ipsum/ridiculus/tellus',
                    'dataFixtures' => [],
                ],
                0 => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => 'pharetra',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield 'Two full descriptors' => [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            [
                'Euismod\Egestas\Mattis' => [
                    'name' => 'MattisBundle',
                    'shortName' => 'mattis',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Euismod\Egestas\Mattis',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                'Vestibulum\Amet\Vehicula' => [
                    'name' => 'VehiculaBundle',
                    'shortName' => 'vehicula',
                    'configurationRootName' => 'ipsummattis',
                    'rootNamespace' => 'Vestibulum\Amet\Vehicula',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        $descriptors = Descriptors::fromArray([
            [
                'name' => 'MattisBundle',
                'rootNamespace' => 'Euismod\Egestas\Mattis',
            ],
            [
                'name' => 'VehiculaBundle',
                'configurationRootName' => 'ipsummattis',
                'rootNamespace' => 'Vestibulum\Amet\Vehicula',
            ],
        ]);

        yield 'Two full descriptors - compared to result of fromArray() method' => [
            $descriptors,
            [
                'Euismod\Egestas\Mattis' => [
                    'name' => 'MattisBundle',
                    'shortName' => 'mattis',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Euismod\Egestas\Mattis',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                'Vestibulum\Amet\Vehicula' => [
                    'name' => 'VehiculaBundle',
                    'shortName' => 'vehicula',
                    'configurationRootName' => 'ipsummattis',
                    'rootNamespace' => 'Vestibulum\Amet\Vehicula',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];
    }

    /**
     * Provides descriptor and class namespace
     *
     * @return Generator
     */
    public function provideDescriptorAndClassNamespace(): Generator
    {
        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'Vestibulum\Amet\Vehicula\Egestas',
            new Descriptor(
                'VehiculaBundle',
                'ipsummattis',
                'Vestibulum\Amet\Vehicula'
            ),
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
                new Descriptor(
                    'SollicitudinBundle',
                    'ipsummattis',
                    'Cras\Risus\Amet',
                    '',
                    new Descriptor(
                        'SemBundle',
                        '',
                        'Fringilla\Quam\Mollis'
                    )
                ),
            ]),
            'Cras\Risus\Amet\Vehicula\Egestas',
            new Descriptor(
                'SollicitudinBundle',
                'ipsummattis',
                'Cras\Risus\Amet',
                '',
                new Descriptor(
                    'SemBundle',
                    '',
                    'Fringilla\Quam\Mollis'
                )
            ),
        ];
    }

    /**
     * Provides descriptor and name
     *
     * @return Generator
     */
    public function provideDescriptorAndName(): Generator
    {
        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'VehiculaBundle',
            new Descriptor(
                'VehiculaBundle',
                'ipsummattis',
                'Vestibulum\Amet\Vehicula'
            ),
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
                new Descriptor(
                    'SollicitudinBundle',
                    'ipsummattis',
                    'Cras\Risus\Amet',
                    '',
                    new Descriptor(
                        'SemBundle',
                        '',
                        'Fringilla\Quam\Mollis'
                    )
                ),
            ]),
            'SollicitudinBundle',
            new Descriptor(
                'SollicitudinBundle',
                'ipsummattis',
                'Cras\Risus\Amet',
                '',
                new Descriptor(
                    'SemBundle',
                    '',
                    'Fringilla\Quam\Mollis'
                )
            ),
        ];
    }

    /**
     * Provides not existing descriptor and class namespace
     *
     * @return Generator
     */
    public function provideNotExistingDescriptorAndClassNamespace(): Generator
    {
        yield [
            new Descriptors(),
            '',
            null,
        ];

        yield [
            new Descriptors(),
            'Vulputate\Commodo\Egestas',
            null,
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'Vulputate\Commodo\Egestas',
            null,
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'Vulputate\Commodo\Egestas',
            null,
        ];
    }

    /**
     * Provides not existing descriptor and name
     *
     * @return Generator
     */
    public function provideNotExistingDescriptorAndName(): Generator
    {
        yield [
            new Descriptors(),
            '',
            null,
        ];

        yield [
            new Descriptors(),
            'VulputateBundle',
            null,
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'CommodoBundle',
            null,
        ];

        yield [
            new Descriptors([
                new Descriptor(
                    'MattisBundle',
                    '',
                    'Euismod\Egestas\Mattis'
                ),
                new Descriptor(
                    'VehiculaBundle',
                    'ipsummattis',
                    'Vestibulum\Amet\Vehicula'
                ),
            ]),
            'EgestasBundle',
            null,
        ];
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(Descriptors::class, OopVisibilityType::IS_PUBLIC, 1);
    }

    /**
     * @param array       $data     Data of descriptors
     * @param Descriptors $expected Expected descriptors
     *
     * @dataProvider provideArrayForDescriptors
     */
    public function testFromArray(array $data, Descriptors $expected): void
    {
        $descriptors = Descriptors::fromArray($data);
        static::assertEquals($expected, $descriptors);
    }

    /**
     * @param Descriptors $descriptors    Descriptors of bundles
     * @param string      $classNamespace Namespace of class for which descriptor of bundle should be returned
     * @param Descriptor  $expected       Expected descriptor
     *
     * @dataProvider provideDescriptorAndClassNamespace
     */
    public function testGetDescriptor(Descriptors $descriptors, string $classNamespace, Descriptor $expected): void
    {
        $descriptor = $descriptors->getDescriptor($classNamespace);

        static::assertSame($expected->getName(), $descriptor->getName());
        static::assertSame($expected->getConfigurationRootName(), $descriptor->getConfigurationRootName());
        static::assertSame($expected->getRootNamespace(), $descriptor->getRootNamespace());
        static::assertSame($expected->getPath(), $descriptor->getPath());
        static::assertSame($expected->getDataFixtures()->toArray(), $descriptor->getDataFixtures()->toArray());
        static::assertSame($expected->getShortName(), $descriptor->getShortName());
        static::assertSame($expected->getDataFixturesDirectoryPath(), $descriptor->getDataFixturesDirectoryPath());

        if (null !== $expected->getParentBundleDescriptor()) {
            static::assertSame(
                $expected->getParentBundleDescriptor()->toArray(),
                $descriptor->getParentBundleDescriptor()->toArray()
            );
        }

        if (null !== $expected->getChildBundleDescriptor()) {
            static::assertSame(
                $expected->getChildBundleDescriptor()->toArray(),
                $descriptor->getChildBundleDescriptor()->toArray()
            );
        }
    }

    /**
     * @param Descriptors $descriptors Descriptors of bundles
     * @param string      $bundleName  Name of bundle who descriptor should be returned
     * @param Descriptor  $expected    Expected descriptor
     *
     * @dataProvider provideDescriptorAndName
     */
    public function testGetDescriptorByName(Descriptors $descriptors, string $bundleName, Descriptor $expected): void
    {
        $descriptor = $descriptors->getDescriptorByName($bundleName);

        static::assertSame($expected->getName(), $descriptor->getName());
        static::assertSame($expected->getConfigurationRootName(), $descriptor->getConfigurationRootName());
        static::assertSame($expected->getRootNamespace(), $descriptor->getRootNamespace());
        static::assertSame($expected->getPath(), $descriptor->getPath());
        static::assertSame($expected->getDataFixtures()->toArray(), $descriptor->getDataFixtures()->toArray());
        static::assertSame($expected->getShortName(), $descriptor->getShortName());
        static::assertSame($expected->getDataFixturesDirectoryPath(), $descriptor->getDataFixturesDirectoryPath());

        if (null !== $expected->getParentBundleDescriptor()) {
            static::assertSame(
                $expected->getParentBundleDescriptor()->toArray(),
                $descriptor->getParentBundleDescriptor()->toArray()
            );
        }

        if (null !== $expected->getChildBundleDescriptor()) {
            static::assertSame(
                $expected->getChildBundleDescriptor()->toArray(),
                $descriptor->getChildBundleDescriptor()->toArray()
            );
        }
    }

    /**
     * @param Descriptors $descriptors Descriptors of bundles
     * @param string      $bundleName  Name of bundle who descriptor should be returned
     *
     * @dataProvider provideNotExistingDescriptorAndName
     */
    public function testGetDescriptorByNameWhenDoesNotExist(Descriptors $descriptors, string $bundleName): void
    {
        static::assertNull($descriptors->getDescriptorByName($bundleName));
    }

    /**
     * @param Descriptors $descriptors    Descriptors of bundles
     * @param string      $classNamespace Namespace of class for which descriptor of bundle should be returned
     *
     * @dataProvider provideNotExistingDescriptorAndClassNamespace
     */
    public function testGetDescriptorWhenDoesNotExist(Descriptors $descriptors, string $classNamespace): void
    {
        static::assertNull($descriptors->getDescriptor($classNamespace));
    }

    /**
     * @param Descriptors $descriptors Descriptors of bundles
     * @param array       $expected    Expected array
     *
     * @dataProvider provideArrayFromDescriptors
     */
    public function testToArray(Descriptors $descriptors, array $expected): void
    {
        static::assertSame($expected, $descriptors->toArray());
    }
}
