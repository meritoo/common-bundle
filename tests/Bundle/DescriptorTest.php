<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Bundle;

use Meritoo\Common\Collection\Collection;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Bundle\Descriptor;
use Meritoo\Test\CommonBundle\Bundle\Descriptor\SimpleBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class DescriptorTest
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class DescriptorTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(Descriptor::class, OopVisibilityType::IS_PUBLIC, 6);
    }

    public function testConstructorUsingDefaults(): void
    {
        $descriptor = new Descriptor();

        static::assertSame('', $descriptor->getName());
        static::assertSame('', $descriptor->getConfigurationRootName());
        static::assertSame('', $descriptor->getRootNamespace());
        static::assertSame('', $descriptor->getPath());
        static::assertNull($descriptor->getChildBundleDescriptor());
        static::assertNull($descriptor->getParentBundleDescriptor());
    }

    public function testSetConfigurationRootName(): void
    {
        $descriptor = new Descriptor();
        $result = $descriptor->setConfigurationRootName('test');

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame('test', $descriptor->getConfigurationRootName());
    }

    public function testSetRootNamespace(): void
    {
        $descriptor = new Descriptor();
        $result = $descriptor->setRootNamespace('test');

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame('test', $descriptor->getRootNamespace());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who path should be returned
     * @param string     $expected   Expected physical path of the bundle
     *
     * @dataProvider providePath
     */
    public function testGetPath(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getPath());
    }

    public function testSetChildBundleDescriptor(): void
    {
        $descriptor = new Descriptor('MyBundle');
        $childDescriptor = new Descriptor('MyChildBundle');
        $result = $descriptor->setChildBundleDescriptor($childDescriptor);

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertInstanceOf(Descriptor::class, $descriptor->getChildBundleDescriptor());
        static::assertSame('MyBundle', $descriptor->getName());
        static::assertSame('MyChildBundle', $childDescriptor->getName());
    }

    /**
     * @param array      $array    Data of descriptor
     * @param Descriptor $expected Expected descriptor
     *
     * @dataProvider provideArrayForDescriptor
     */
    public function testFromArray(array $array, Descriptor $expected): void
    {
        $fromArray = Descriptor::fromArray($array);

        static::assertInstanceOf(Descriptor::class, $fromArray);
        static::assertSame($expected->toArray(), $fromArray->toArray());

        static::assertSame($expected->getName(), $fromArray->getName());
        static::assertSame($expected->getConfigurationRootName(), $fromArray->getConfigurationRootName());
        static::assertSame($expected->getRootNamespace(), $fromArray->getRootNamespace());
        static::assertSame($expected->getPath(), $fromArray->getPath());
        static::assertSame($expected->getDataFixtures()->toArray(), $fromArray->getDataFixtures()->toArray());
        static::assertSame($expected->getShortName(), $fromArray->getShortName());
        static::assertSame($expected->getDataFixturesDirectoryPath(), $fromArray->getDataFixturesDirectoryPath());

        if (null !== $expected->getParentBundleDescriptor()) {
            static::assertSame(
                $expected->getParentBundleDescriptor()->toArray(),
                $fromArray->getParentBundleDescriptor()->toArray()
            );
        }

        if (null !== $expected->getChildBundleDescriptor()) {
            static::assertSame(
                $expected->getChildBundleDescriptor()->toArray(),
                $fromArray->getChildBundleDescriptor()->toArray()
            );
        }
    }

    public function testSetPath(): void
    {
        $descriptor = new Descriptor();
        $result = $descriptor->setPath('this/is/path');

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame('this/is/path', $descriptor->getPath());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who short, simple name should be returned
     * @param string     $expected   Expected short, simple name of the bundle
     *
     * @dataProvider provideShortName
     */
    public function testGetShortName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getShortName());
    }

    /**
     * @param Descriptor  $descriptor Descriptor of bundle who path of directory with classes for the DataFixtures
     *                                should be returned
     * @param string|null $expected   Expected path
     *
     * @dataProvider provideDataFixturesPath
     */
    public function testGetDataFixturesDirectoryPath(Descriptor $descriptor, ?string $expected): void
    {
        static::assertSame($expected, $descriptor->getDataFixturesDirectoryPath());
    }

    /**
     * @param Descriptor      $descriptor Descriptor of bundle who descriptor of the child bundle should be returned
     * @param Descriptor|null $expected   Expected descriptor of the child bundle
     *
     * @dataProvider provideChildBundleDescriptor
     */
    public function testGetChildBundleDescriptor(Descriptor $descriptor, ?Descriptor $expected): void
    {
        static::assertSame($expected, $descriptor->getChildBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor         Descriptor of bundle who an array representation should be returned
     * @param bool       $withParentAndChild If is set to true, includes descriptor of the parent and child bundle
     *                                       (default behaviour). Otherwise - not.
     * @param array      $expected           Expected array
     *
     * @dataProvider provideArrayFromDescriptor
     */
    public function testToArray(Descriptor $descriptor, bool $withParentAndChild, array $expected): void
    {
        static::assertSame($expected, $descriptor->toArray($withParentAndChild));
    }

    public function testSetName(): void
    {
        $descriptor = new Descriptor();
        $result = $descriptor->setName('MyExtraBundle');

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame('MyExtraBundle', $descriptor->getName());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who root namespace of bundle should be returned
     * @param string     $expected   Expected root namespace of bundle
     *
     * @dataProvider provideRootNamespace
     */
    public function testGetRootNamespace(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getRootNamespace());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who names of files with data fixtures from bundle
     * @param Collection $expected   Expected names of files with data fixtures
     *
     * @dataProvider provideDataFixtures
     */
    public function testGetDataFixtures(Descriptor $descriptor, Collection $expected): void
    {
        static::assertSame($expected->count(), $descriptor->getDataFixtures()->count());
        static::assertSame($expected->toArray(), $descriptor->getDataFixtures()->toArray());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who should be verified if file belongs to the bundle
     * @param string     $filePath   Path of file to verify
     * @param bool       $expected   Expected result of verification
     *
     * @dataProvider provideFilePath
     */
    public function testHasFile(Descriptor $descriptor, string $filePath, bool $expected): void
    {
        static::assertSame($expected, $descriptor->hasFile($filePath));
    }

    public function testSetParentBundleDescriptor()
    {
        $descriptor = new Descriptor();
        $result = $descriptor->setParentBundleDescriptor(null);

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertNull($descriptor->getParentBundleDescriptor());

        $parentBundleDescriptor = new Descriptor();
        $result = $descriptor->setParentBundleDescriptor($parentBundleDescriptor);

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame($parentBundleDescriptor, $descriptor->getParentBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who name of configuration root node of bundle should be
     *                               returned
     * @param string     $expected   Expected name of configuration root node
     *
     * @dataProvider provideConfigurationRootName
     */
    public function testGetConfigurationRootName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getConfigurationRootName());
    }

    /**
     * @param Descriptor $descriptor    Descriptor of bundle for who names of files with data fixtures should be added
     * @param array      $fixturesPaths Names of files with data fixtures to add
     * @param Collection $expected      Expected names of files with data fixtures after add
     *
     * @dataProvider provideDataFixturesToAdd
     */
    public function testAddDataFixtures(Descriptor $descriptor, array $fixturesPaths, Collection $expected): void
    {
        $result = $descriptor->addDataFixtures($fixturesPaths);

        static::assertInstanceOf(Descriptor::class, $result);
        static::assertSame($expected->count(), $descriptor->getDataFixtures()->count());
        static::assertSame($expected->toArray(), $descriptor->getDataFixtures()->toArray());
    }

    /**
     * @param Descriptor      $descriptor Descriptor of bundle who descriptor of the parent bundle should be returned
     * @param Descriptor|null $expected   Expected descriptor of the parent bundle
     *
     * @dataProvider provideParentBundleDescriptor
     */
    public function testGetParentBundleDescriptor(Descriptor $descriptor, ?Descriptor $expected): void
    {
        static::assertSame($expected, $descriptor->getParentBundleDescriptor());
    }

    /**
     * @param Bundle     $bundle   The bundle
     * @param Descriptor $expected Expected descriptor
     *
     * @dataProvider provideBundle
     */
    public function testFromBundle(Bundle $bundle, Descriptor $expected): void
    {
        $descriptor = Descriptor::fromBundle($bundle);

        static::assertSame($expected->getName(), $descriptor->getName());
        static::assertSame($expected->getConfigurationRootName(), $descriptor->getConfigurationRootName());
        static::assertSame($expected->getRootNamespace(), $descriptor->getRootNamespace());
        static::assertContains($expected->getPath(), $descriptor->getPath());
        static::assertNull($descriptor->getChildBundleDescriptor());
        static::assertNull($descriptor->getParentBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who name should be returned
     * @param string     $expected   Expected name
     *
     * @dataProvider provideName
     */
    public function testGetName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getName());
    }

    /**
     * Provides array with data of descriptor and the expected descriptor
     */
    public function provideArrayForDescriptor()
    {
        yield[
            [],
            new Descriptor(),
        ];

        yield[
            [
                'name'                  => 'Risus',
                'configurationRootName' => 'Ridiculus',
            ],
            new Descriptor('Risus', 'Ridiculus'),
        ];

        yield[
            [
                'name'                   => 'Sollicitudin',
                'configurationRootName'  => 'Vulputate',
                'parentBundleDescriptor' => [],
            ],
            new Descriptor('Sollicitudin', 'Vulputate'),
        ];

        yield[
            [
                'name'                   => 'Nibh',
                'configurationRootName'  => 'Consectetur',
                'parentBundleDescriptor' => [],
            ],
            new Descriptor('Nibh', 'Consectetur'),
        ];

        yield[
            [
                'name'                  => 'Vestibulum',
                'configurationRootName' => 'Tristique',
                'childBundleDescriptor' => [],
            ],
            new Descriptor('Vestibulum', 'Tristique'),
        ];

        yield[
            [
                'name'                   => 'Pellentesque',
                'configurationRootName'  => 'Commodo',
                'parentBundleDescriptor' => [
                    'name'                  => 'Vulputate',
                    'configurationRootName' => 'Dolor',
                ],
            ],
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
        ];

        yield[
            [
                'name'                  => 'Mollis',
                'configurationRootName' => 'Vulputate',
                'childBundleDescriptor' => [
                    'name'                  => 'Euismod',
                    'configurationRootName' => 'Quam',
                ],
            ],
            new Descriptor(
                'Mollis',
                'Vulputate',
                '',
                '',
                null,
                new Descriptor(
                    'Euismod',
                    'Quam'
                )
            ),
        ];

        yield[
            [
                'name'                   => 'Tellus',
                'configurationRootName'  => 'Porta',
                'rootNamespace'          => 'Mollis\Ipsum\Etiam\Ullamcorper',
                'path'                   => 'pellentesque/tortor/ultricies/quam',
                'parentBundleDescriptor' => [
                    'name'                  => 'Venenatis',
                    'configurationRootName' => 'Sem',
                ],
                'childBundleDescriptor'  => [
                    'name'                  => 'Adipiscing',
                    'configurationRootName' => 'Etiam',
                    'rootNamespace'         => 'Ornare\Malesuada\Venenatis\Consectetur',
                ],
            ],
            new Descriptor(
                'Tellus',
                'Porta',
                'Mollis\Ipsum\Etiam\Ullamcorper',
                'pellentesque/tortor/ultricies/quam',
                new Descriptor(
                    'Venenatis',
                    'Sem'
                ),
                new Descriptor(
                    'Adipiscing',
                    'Etiam',
                    'Ornare\Malesuada\Venenatis\Consectetur'
                )
            ),
        ];
    }

    /**
     * Provides descriptor of bundle who short, simple name should be returned and the short name
     */
    public function provideShortName()
    {
        yield[
            new Descriptor(),
            '',
        ];

        yield[
            new Descriptor('SimpleBundle'),
            'simple',
        ];

        yield[
            new Descriptor('ExtraSimpleBundle'),
            'extrasimple',
        ];

        yield[
            new Descriptor('Invalid Name Bundle'),
            'invalid name',
        ];
    }

    /**
     * Provides descriptor of bundle and physical path of the bundle
     */
    public function providePath()
    {
        yield[
            new Descriptor(),
            '',
        ];

        yield[
            new Descriptor('', '', '', ''),
            '',
        ];

        yield[
            new Descriptor('', '', '', 'path/of/bundle'),
            'path/of/bundle',
        ];
    }

    /**
     * Provides descriptor of bundle and real/full path of directory with classes for the DataFixtures
     */
    public function provideDataFixturesPath()
    {
        yield[
            new Descriptor(),
            null,
        ];

        yield[
            new Descriptor('', '', '', 'path/of/bundle'),
            sprintf('/%s/%s', 'path/of/bundle', Descriptor::PATH_DATA_FIXTURES),
        ];
    }

    /**
     * Provides descriptor of bundle and descriptor of the child bundle
     */
    public function provideChildBundleDescriptor()
    {
        yield[
            new Descriptor(),
            null,
        ];

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                null
            ),
            null,
        ];

        $childBundleDescriptor = new Descriptor();

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                $childBundleDescriptor
            ),
            $childBundleDescriptor,
        ];

        $childBundleDescriptor = new Descriptor(
            'Test',
            '',
            'This/Is/Namespace'
        );

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                $childBundleDescriptor
            ),
            $childBundleDescriptor,
        ];
    }

    /**
     * Provides descriptor of bundle and an array representation of the descriptor
     */
    public function provideArrayFromDescriptor()
    {
        yield[
            new Descriptor(),
            true,
            [
                'name'                  => '',
                'shortName'             => '',
                'configurationRootName' => '',
                'rootNamespace'         => '',
                'path'                  => '',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(),
            false,
            [
                'name'                  => '',
                'shortName'             => '',
                'configurationRootName' => '',
                'rootNamespace'         => '',
                'path'                  => '',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient'
            ),
            true,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient'
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor()
            ),
            true,
            [
                'name'                   => 'PortaCommodoBundle',
                'shortName'              => 'portacommodo',
                'configurationRootName'  => 'Commodo',
                'rootNamespace'          => 'Porta\CommodoBundle',
                'path'                   => 'etiam/risus/parturient',
                'dataFixtures'           => [],
                'parentBundleDescriptor' => [
                    'name'                  => '',
                    'shortName'             => '',
                    'configurationRootName' => '',
                    'rootNamespace'         => '',
                    'path'                  => '',
                    'dataFixtures'          => [],
                ],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor()
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                null,
                new Descriptor()
            ),
            true,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
                'childBundleDescriptor' => [
                    'name'                  => '',
                    'shortName'             => '',
                    'configurationRootName' => '',
                    'rootNamespace'         => '',
                    'path'                  => '',
                    'dataFixtures'          => [],
                ],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                null,
                new Descriptor()
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
                new Descriptor()
            ),
            true,
            [
                'name'                   => 'PortaCommodoBundle',
                'shortName'              => 'portacommodo',
                'configurationRootName'  => 'Commodo',
                'rootNamespace'          => 'Porta\CommodoBundle',
                'path'                   => 'etiam/risus/parturient',
                'dataFixtures'           => [],
                'parentBundleDescriptor' => [
                    'name'                  => '',
                    'shortName'             => '',
                    'configurationRootName' => '',
                    'rootNamespace'         => '',
                    'path'                  => '',
                    'dataFixtures'          => [],
                ],
                'childBundleDescriptor'  => [
                    'name'                  => '',
                    'shortName'             => '',
                    'configurationRootName' => '',
                    'rootNamespace'         => '',
                    'path'                  => '',
                    'dataFixtures'          => [],
                ],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
                new Descriptor()
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus'
                ),
                new Descriptor()
            ),
            true,
            [
                'name'                   => 'PortaCommodoBundle',
                'shortName'              => 'portacommodo',
                'configurationRootName'  => 'Commodo',
                'rootNamespace'          => 'Porta\CommodoBundle',
                'path'                   => 'etiam/risus/parturient',
                'dataFixtures'           => [],
                'parentBundleDescriptor' => [
                    'name'                  => 'OrnareEgestasBundle',
                    'shortName'             => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace'         => 'Ornare\EgestasBundle',
                    'path'                  => 'condimentum/fusce/risus',
                    'dataFixtures'          => [],
                ],
                'childBundleDescriptor'  => [
                    'name'                  => '',
                    'shortName'             => '',
                    'configurationRootName' => '',
                    'rootNamespace'         => '',
                    'path'                  => '',
                    'dataFixtures'          => [],
                ],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus'
                ),
                new Descriptor()
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus'
                ),
                new Descriptor(
                    'ParturientPharetraBundle',
                    'OrnareMattis',
                    'Parturient\PharetraBundle',
                    'tortor/ullamcorper/mattis'
                )
            ),
            true,
            [
                'name'                   => 'PortaCommodoBundle',
                'shortName'              => 'portacommodo',
                'configurationRootName'  => 'Commodo',
                'rootNamespace'          => 'Porta\CommodoBundle',
                'path'                   => 'etiam/risus/parturient',
                'dataFixtures'           => [],
                'parentBundleDescriptor' => [
                    'name'                  => 'OrnareEgestasBundle',
                    'shortName'             => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace'         => 'Ornare\EgestasBundle',
                    'path'                  => 'condimentum/fusce/risus',
                    'dataFixtures'          => [],
                ],
                'childBundleDescriptor'  => [
                    'name'                  => 'ParturientPharetraBundle',
                    'shortName'             => 'parturientpharetra',
                    'configurationRootName' => 'OrnareMattis',
                    'rootNamespace'         => 'Parturient\PharetraBundle',
                    'path'                  => 'tortor/ullamcorper/mattis',
                    'dataFixtures'          => [],
                ],
            ],
        ];

        yield[
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus'
                ),
                new Descriptor(
                    'ParturientPharetraBundle',
                    'OrnareMattis',
                    'Parturient\PharetraBundle',
                    'tortor/ullamcorper/mattis'
                )
            ),
            false,
            [
                'name'                  => 'PortaCommodoBundle',
                'shortName'             => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace'         => 'Porta\CommodoBundle',
                'path'                  => 'etiam/risus/parturient',
                'dataFixtures'          => [],
            ],
        ];
    }

    /**
     * Provides descriptor of bundle and root namespace of bundle
     */
    public function provideRootNamespace()
    {
        yield[
            new Descriptor(),
            '',
        ];

        yield[
            new Descriptor('', '', ''),
            '',
        ];

        yield[
            new Descriptor('', '', 'Purus\Bibendum\Fusce'),
            'Purus\Bibendum\Fusce',
        ];
    }

    /**
     * Provides descriptor of bundle and names of files with data fixtures
     */
    public function provideDataFixtures()
    {
        yield[
            new Descriptor(),
            new Collection(),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([]);

        yield[
            $descriptor,
            new Collection(),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([
            'first/path/with/fixtures',
            'second/path/with/fixtures',
        ]);

        yield[
            $descriptor,
            new Collection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ]),
        ];
    }

    /**
     * Provides descriptor of bundle and path of file to verify
     */
    public function provideFilePath()
    {
        yield[
            new Descriptor(),
            '',
            false,
        ];

        yield[
            new Descriptor(),
            'path/of/file',
            false,
        ];

        yield[
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'path/of/file',
            false,
        ];

        yield[
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'dapibus/venenatis/quam/path/of/file',
            true,
        ];

        yield[
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'dapibus/venenatis/quam/path/of/file/with/extens.ion',
            true,
        ];
    }

    /**
     * Provides descriptor of bundle and name of configuration root node
     */
    public function provideConfigurationRootName()
    {
        yield[
            new Descriptor(),
            '',
        ];

        yield[
            new Descriptor('', ''),
            '',
        ];

        yield[
            new Descriptor('', 'aeneanvulputate'),
            'aeneanvulputate',
        ];
    }

    /**
     * Provides descriptor of bundle and names of files with data fixtures to add
     */
    public function provideDataFixturesToAdd()
    {
        yield[
            new Descriptor(),
            [],
            new Collection(),
        ];

        yield[
            new Descriptor(),
            [
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ],
            new Collection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ]),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([
            'first/path/with/fixtures',
            'second/path/with/fixtures',
        ]);

        yield[
            $descriptor,
            [
                'third/path/with/fixtures',
                'fourth/path/with/fixtures',
            ],
            new Collection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
                'third/path/with/fixtures',
                'fourth/path/with/fixtures',
            ]),
        ];
    }

    /**
     * Provides descriptor of bundle and descriptor of the child bundle
     */
    public function provideParentBundleDescriptor()
    {
        yield[
            new Descriptor(),
            null,
        ];

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                null
            ),
            null,
        ];

        $parentBundleDescriptor = new Descriptor();

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                $parentBundleDescriptor,
                null
            ),
            $parentBundleDescriptor,
        ];

        $parentBundleDescriptor = new Descriptor(
            'Test',
            '',
            'This/Is/Namespace'
        );

        yield[
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                $parentBundleDescriptor,
                null
            ),
            $parentBundleDescriptor,
        ];
    }

    /**
     * Provides bundle and descriptor of the bundle
     */
    public function provideBundle()
    {
        yield[
            new SimpleBundle(),
            new Descriptor(
                'SimpleBundle',
                '',
                'Meritoo\Test\CommonBundle\Bundle\Descriptor',
                '/project/tests/Bundle/Descriptor'
            ),
        ];
    }

    /**
     * Provides descriptor and name of the bundle
     */
    public function provideName()
    {
        yield[
            new Descriptor(),
            '',
        ];

        yield[
            new Descriptor(''),
            '',
        ];

        yield[
            new Descriptor('MySimpleBundle'),
            'MySimpleBundle',
        ];
    }
}
