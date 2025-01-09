<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Bundle;

use Generator;
use Meritoo\Common\Collection\StringCollection;
use Meritoo\Common\Enums\OopVisibility;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\Bundle\Descriptor;
use Meritoo\Test\CommonBundle\Bundle\Descriptor\SimpleBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Test case of the descriptor of bundle
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Bundle\Descriptor
 */
class DescriptorTest extends BaseTestCase
{
    /**
     * Provides array with data of descriptor and the expected descriptor
     *
     * @return Generator
     */
    public function provideArrayForDescriptor(): Generator
    {
        yield [
            [],
            new Descriptor(),
        ];

        yield [
            [
                'name' => 'Risus',
                'configurationRootName' => 'Ridiculus',
            ],
            new Descriptor('Risus', 'Ridiculus'),
        ];

        yield [
            [
                'name' => 'Sollicitudin',
                'configurationRootName' => 'Vulputate',
                'parentBundleDescriptor' => [],
            ],
            new Descriptor('Sollicitudin', 'Vulputate'),
        ];

        yield [
            [
                'name' => 'Nibh',
                'configurationRootName' => 'Consectetur',
                'parentBundleDescriptor' => [],
            ],
            new Descriptor('Nibh', 'Consectetur'),
        ];

        yield [
            [
                'name' => 'Vestibulum',
                'configurationRootName' => 'Tristique',
                'childBundleDescriptor' => [],
            ],
            new Descriptor('Vestibulum', 'Tristique'),
        ];

        yield [
            [
                'name' => 'Pellentesque',
                'configurationRootName' => 'Commodo',
                'parentBundleDescriptor' => [
                    'name' => 'Vulputate',
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
                    'Dolor',
                ),
            ),
        ];

        yield [
            [
                'name' => 'Mollis',
                'configurationRootName' => 'Vulputate',
                'childBundleDescriptor' => [
                    'name' => 'Euismod',
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
                    'Quam',
                ),
            ),
        ];

        yield [
            [
                'name' => 'Tellus',
                'configurationRootName' => 'Porta',
                'rootNamespace' => 'Mollis\Ipsum\Etiam\Ullamcorper',
                'path' => 'pellentesque/tortor/ultricies/quam',
                'parentBundleDescriptor' => [
                    'name' => 'Venenatis',
                    'configurationRootName' => 'Sem',
                ],
                'childBundleDescriptor' => [
                    'name' => 'Adipiscing',
                    'configurationRootName' => 'Etiam',
                    'rootNamespace' => 'Ornare\Malesuada\Venenatis\Consectetur',
                ],
            ],
            new Descriptor(
                'Tellus',
                'Porta',
                'Mollis\Ipsum\Etiam\Ullamcorper',
                'pellentesque/tortor/ultricies/quam',
                new Descriptor(
                    'Venenatis',
                    'Sem',
                ),
                new Descriptor(
                    'Adipiscing',
                    'Etiam',
                    'Ornare\Malesuada\Venenatis\Consectetur',
                ),
            ),
        ];
    }

    /**
     * Provides descriptor of bundle and an array representation of the descriptor
     *
     * @return Generator
     */
    public function provideArrayFromDescriptor(): Generator
    {
        yield [
            new Descriptor(),
            true,
            [
                'name' => '',
                'shortName' => '',
                'configurationRootName' => '',
                'rootNamespace' => '',
                'path' => '',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(),
            false,
            [
                'name' => '',
                'shortName' => '',
                'configurationRootName' => '',
                'rootNamespace' => '',
                'path' => '',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                null,
                new Descriptor(),
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'childBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                null,
                new Descriptor(),
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
                new Descriptor(),
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
                new Descriptor(),
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(),
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => 'OrnareEgestasBundle',
                    'shortName' => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace' => 'Ornare\EgestasBundle',
                    'path' => 'condimentum/fusce/risus',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(),
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(
                    'ParturientPharetraBundle',
                    'OrnareMattis',
                    'Parturient\PharetraBundle',
                    'tortor/ullamcorper/mattis',
                ),
            ),
            true,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => 'OrnareEgestasBundle',
                    'shortName' => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace' => 'Ornare\EgestasBundle',
                    'path' => 'condimentum/fusce/risus',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => 'ParturientPharetraBundle',
                    'shortName' => 'parturientpharetra',
                    'configurationRootName' => 'OrnareMattis',
                    'rootNamespace' => 'Parturient\PharetraBundle',
                    'path' => 'tortor/ullamcorper/mattis',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(
                    'ParturientPharetraBundle',
                    'OrnareMattis',
                    'Parturient\PharetraBundle',
                    'tortor/ullamcorper/mattis',
                ),
            ),
            false,
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
            ],
        ];
    }

    /**
     * Provides descriptor of bundle and an array representation of the descriptor (using default arguments)
     *
     * @return Generator
     */
    public function provideArrayFromDescriptorUsingDefaults(): Generator
    {
        yield [
            new Descriptor(),
            [
                'name' => '',
                'shortName' => '',
                'configurationRootName' => '',
                'rootNamespace' => '',
                'path' => '',
                'dataFixtures' => [],
                'parentBundleDescriptor' => null,
                'childBundleDescriptor' => null,
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
            ),
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => null,
                'childBundleDescriptor' => null,
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
            ),
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => null,
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(),
                new Descriptor(),
            ),
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(),
            ),
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => 'OrnareEgestasBundle',
                    'shortName' => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace' => 'Ornare\EgestasBundle',
                    'path' => 'condimentum/fusce/risus',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => '',
                    'shortName' => '',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [],
                ],
            ],
        ];

        yield [
            new Descriptor(
                'PortaCommodoBundle',
                'Commodo',
                'Porta\CommodoBundle',
                'etiam/risus/parturient',
                new Descriptor(
                    'OrnareEgestasBundle',
                    'Ornare',
                    'Ornare\EgestasBundle',
                    'condimentum/fusce/risus',
                ),
                new Descriptor(
                    'ParturientPharetraBundle',
                    'OrnareMattis',
                    'Parturient\PharetraBundle',
                    'tortor/ullamcorper/mattis',
                ),
            ),
            [
                'name' => 'PortaCommodoBundle',
                'shortName' => 'portacommodo',
                'configurationRootName' => 'Commodo',
                'rootNamespace' => 'Porta\CommodoBundle',
                'path' => 'etiam/risus/parturient',
                'dataFixtures' => [],
                'parentBundleDescriptor' => [
                    'name' => 'OrnareEgestasBundle',
                    'shortName' => 'ornareegestas',
                    'configurationRootName' => 'Ornare',
                    'rootNamespace' => 'Ornare\EgestasBundle',
                    'path' => 'condimentum/fusce/risus',
                    'dataFixtures' => [],
                ],
                'childBundleDescriptor' => [
                    'name' => 'ParturientPharetraBundle',
                    'shortName' => 'parturientpharetra',
                    'configurationRootName' => 'OrnareMattis',
                    'rootNamespace' => 'Parturient\PharetraBundle',
                    'path' => 'tortor/ullamcorper/mattis',
                    'dataFixtures' => [],
                ],
            ],
        ];
    }

    /**
     * Provides bundle and descriptor of the bundle
     *
     * @return Generator
     */
    public function provideBundle(): Generator
    {
        yield [
            new SimpleBundle(),
            new Descriptor(
                'SimpleBundle',
                '',
                'Meritoo\Test\CommonBundle\Bundle\Descriptor',
                '/tests/Bundle/Descriptor',
            ),
        ];
    }

    /**
     * Provides descriptor of bundle and descriptor of the child bundle
     *
     * @return Generator
     */
    public function provideChildBundleDescriptor(): Generator
    {
        yield [
            new Descriptor(),
            null,
        ];

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                null,
            ),
            null,
        ];

        $childBundleDescriptor = new Descriptor();

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                $childBundleDescriptor,
            ),
            $childBundleDescriptor,
        ];

        $childBundleDescriptor = new Descriptor(
            'Test',
            '',
            'This/Is/Namespace',
        );

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                $childBundleDescriptor,
            ),
            $childBundleDescriptor,
        ];
    }

    /**
     * Provides descriptor of bundle and name of configuration root node
     *
     * @return Generator
     */
    public function provideConfigurationRootName(): Generator
    {
        yield [
            new Descriptor(),
            '',
        ];

        yield [
            new Descriptor('', ''),
            '',
        ];

        yield [
            new Descriptor('', 'aeneanvulputate'),
            'aeneanvulputate',
        ];
    }

    /**
     * Provides descriptor of bundle and names of files with data fixtures
     *
     * @return Generator
     */
    public function provideDataFixtures(): Generator
    {
        yield [
            new Descriptor(),
            new StringCollection(),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([]);

        yield [
            $descriptor,
            new StringCollection(),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([
            'first/path/with/fixtures',
            'second/path/with/fixtures',
        ]);

        yield [
            $descriptor,
            new StringCollection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ]),
        ];
    }

    /**
     * Provides descriptor of bundle and real/full path of directory with classes for the DataFixtures
     *
     * @return Generator
     */
    public function provideDataFixturesPath(): Generator
    {
        yield [
            new Descriptor(),
            null,
        ];

        yield [
            new Descriptor('', '', '', 'path/of/bundle'),
            sprintf('/%s/%s', 'path/of/bundle', Descriptor::PATH_DATA_FIXTURES),
        ];
    }

    /**
     * Provides descriptor of bundle and names of files with data fixtures to add
     *
     * @return Generator
     */
    public function provideDataFixturesToAdd(): Generator
    {
        yield [
            new Descriptor(),
            [],
            new StringCollection(),
        ];

        yield [
            new Descriptor(),
            [
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ],
            new StringCollection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
            ]),
        ];

        $descriptor = (new Descriptor())->addDataFixtures([
            'first/path/with/fixtures',
            'second/path/with/fixtures',
        ]);

        yield [
            $descriptor,
            [
                'third/path/with/fixtures',
                'fourth/path/with/fixtures',
            ],
            new StringCollection([
                'first/path/with/fixtures',
                'second/path/with/fixtures',
                'third/path/with/fixtures',
                'fourth/path/with/fixtures',
            ]),
        ];
    }

    /**
     * Provides descriptor of bundle and path of file to verify
     *
     * @return Generator
     */
    public function provideFilePath(): Generator
    {
        yield [
            new Descriptor(),
            '',
            false,
        ];

        yield [
            new Descriptor(),
            'path/of/file',
            false,
        ];

        yield [
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'path/of/file',
            false,
        ];

        yield [
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'dapibus/venenatis/quam/path/of/file',
            true,
        ];

        yield [
            new Descriptor('', '', '', 'dapibus/venenatis/quam'),
            'dapibus/venenatis/quam/path/of/file/with/extens.ion',
            true,
        ];
    }

    /**
     * Provides descriptor and name of the bundle
     *
     * @return Generator
     */
    public function provideName(): Generator
    {
        yield [
            new Descriptor(),
            '',
        ];

        yield [
            new Descriptor(''),
            '',
        ];

        yield [
            new Descriptor('MySimpleBundle'),
            'MySimpleBundle',
        ];
    }

    /**
     * Provides descriptor of bundle and descriptor of the child bundle
     *
     * @return Generator
     */
    public function provideParentBundleDescriptor(): Generator
    {
        yield [
            new Descriptor(),
            null,
        ];

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                null,
                null,
            ),
            null,
        ];

        $parentBundleDescriptor = new Descriptor();

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                $parentBundleDescriptor,
                null,
            ),
            $parentBundleDescriptor,
        ];

        $parentBundleDescriptor = new Descriptor(
            'Test',
            '',
            'This/Is/Namespace',
        );

        yield [
            new Descriptor(
                'Test',
                '',
                '',
                'path/of/bundle',
                $parentBundleDescriptor,
                null,
            ),
            $parentBundleDescriptor,
        ];
    }

    /**
     * Provides descriptor of bundle and physical path of the bundle
     *
     * @return Generator
     */
    public function providePath(): Generator
    {
        yield [
            new Descriptor(),
            '',
        ];

        yield [
            new Descriptor('', '', '', ''),
            '',
        ];

        yield [
            new Descriptor('', '', '', 'path/of/bundle'),
            'path/of/bundle',
        ];
    }

    /**
     * Provides descriptor of bundle and root namespace of bundle
     *
     * @return Generator
     */
    public function provideRootNamespace(): Generator
    {
        yield [
            new Descriptor(),
            '',
        ];

        yield [
            new Descriptor('', '', ''),
            '',
        ];

        yield [
            new Descriptor('', '', 'Purus\Bibendum\Fusce'),
            'Purus\Bibendum\Fusce',
        ];
    }

    /**
     * Provides descriptor of bundle who short, simple name should be returned and the short name
     *
     * @return Generator
     */
    public function provideShortName(): Generator
    {
        yield [
            new Descriptor(),
            '',
        ];

        yield [
            new Descriptor('SimpleBundle'),
            'simple',
        ];

        yield [
            new Descriptor('ExtraSimpleBundle'),
            'extrasimple',
        ];

        yield [
            new Descriptor('Invalid Name Bundle'),
            'invalid name',
        ];
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle for who names of files with data fixtures should be added
     * @param array $fixturesPaths Names of files with data fixtures to add
     * @param StringCollection $expected Expected names of files with data fixtures after add
     *
     * @dataProvider provideDataFixturesToAdd
     * @covers       \Meritoo\CommonBundle\Bundle\Descriptor::addDataFixtures
     */
    public function testAddDataFixtures(Descriptor $descriptor, array $fixturesPaths, StringCollection $expected): void
    {
        $descriptor->addDataFixtures($fixturesPaths);

        static::assertSame($expected->count(), $descriptor->getDataFixtures()->count());
        static::assertSame($expected->toArray(), $descriptor->getDataFixtures()->toArray());
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(Descriptor::class, OopVisibility::Public, 6);
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

    /**
     * @param array $array Data of descriptor
     * @param Descriptor $expected Expected descriptor
     *
     * @dataProvider provideArrayForDescriptor
     */
    public function testFromArray(array $array, Descriptor $expected): void
    {
        $descriptor = Descriptor::fromArray($array);

        static::assertSame($expected->toArray(), $descriptor->toArray());
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
                $descriptor->getParentBundleDescriptor()->toArray(),
            );
        }

        if (null !== $expected->getChildBundleDescriptor()) {
            static::assertSame(
                $expected->getChildBundleDescriptor()->toArray(),
                $descriptor->getChildBundleDescriptor()->toArray(),
            );
        }
    }

    /**
     * @param Bundle $bundle The bundle
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
        static::assertStringContainsString($expected->getPath(), $descriptor->getPath());
        static::assertNull($descriptor->getChildBundleDescriptor());
        static::assertNull($descriptor->getParentBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle which descriptor of the child bundle should be returned
     * @param null|Descriptor $expected Expected descriptor of the child bundle
     *
     * @dataProvider provideChildBundleDescriptor
     */
    public function testGetChildBundleDescriptor(Descriptor $descriptor, ?Descriptor $expected): void
    {
        static::assertSame($expected, $descriptor->getChildBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who name of configuration root node of bundle should be
     *                               returned
     * @param string $expected Expected name of configuration root node
     *
     * @dataProvider provideConfigurationRootName
     */
    public function testGetConfigurationRootName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getConfigurationRootName());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who names of files with data fixtures from bundle
     * @param StringCollection $expected Expected names of files with data fixtures
     *
     * @dataProvider provideDataFixtures
     */
    public function testGetDataFixtures(Descriptor $descriptor, StringCollection $expected): void
    {
        static::assertSame($expected->count(), $descriptor->getDataFixtures()->count());
        static::assertSame($expected->toArray(), $descriptor->getDataFixtures()->toArray());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle which path of directory with classes for the DataFixtures
     * should be returned
     * @param null|string $expected Expected path
     *
     * @dataProvider provideDataFixturesPath
     */
    public function testGetDataFixturesDirectoryPath(Descriptor $descriptor, ?string $expected): void
    {
        static::assertSame($expected, $descriptor->getDataFixturesDirectoryPath());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who name should be returned
     * @param string $expected Expected name
     *
     * @dataProvider provideName
     */
    public function testGetName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getName());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle which descriptor of the parent bundle should be returned
     * @param null|Descriptor $expected Expected descriptor of the parent bundle
     *
     * @dataProvider provideParentBundleDescriptor
     */
    public function testGetParentBundleDescriptor(Descriptor $descriptor, ?Descriptor $expected): void
    {
        static::assertSame($expected, $descriptor->getParentBundleDescriptor());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle which path should be returned
     * @param string $expected Expected physical path of the bundle
     *
     * @dataProvider providePath
     */
    public function testGetPath(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getPath());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who root namespace of bundle should be returned
     * @param string $expected Expected root namespace of bundle
     *
     * @dataProvider provideRootNamespace
     */
    public function testGetRootNamespace(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getRootNamespace());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who short, simple name should be returned
     * @param string $expected Expected short, simple name of the bundle
     *
     * @dataProvider provideShortName
     */
    public function testGetShortName(Descriptor $descriptor, string $expected): void
    {
        static::assertSame($expected, $descriptor->getShortName());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who should be verified if file belongs to the bundle
     * @param string $filePath Path of file to verify
     * @param bool $expected Expected result of verification
     *
     * @dataProvider provideFilePath
     */
    public function testHasFile(Descriptor $descriptor, string $filePath, bool $expected): void
    {
        static::assertSame($expected, $descriptor->hasFile($filePath));
    }

    public function testSetChildBundleDescriptor(): void
    {
        $descriptor = new Descriptor('MyBundle');
        $childDescriptor = new Descriptor('MyChildBundle');
        $descriptor->setChildBundleDescriptor($childDescriptor);

        static::assertInstanceOf(Descriptor::class, $descriptor->getChildBundleDescriptor());
        static::assertSame('MyBundle', $descriptor->getName());
        static::assertSame('MyChildBundle', $childDescriptor->getName());
    }

    public function testSetConfigurationRootName(): void
    {
        $descriptor = new Descriptor();
        $descriptor->setConfigurationRootName('test');

        static::assertSame('test', $descriptor->getConfigurationRootName());
    }

    public function testSetName(): void
    {
        $descriptor = new Descriptor();
        $descriptor->setName('MyExtraBundle');

        static::assertSame('MyExtraBundle', $descriptor->getName());
    }

    public function testSetParentBundleDescriptor(): void
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

    public function testSetPath(): void
    {
        $descriptor = new Descriptor();
        $descriptor->setPath('this/is/path');

        static::assertSame('this/is/path', $descriptor->getPath());
    }

    public function testSetRootNamespace(): void
    {
        $descriptor = new Descriptor();
        $descriptor->setRootNamespace('test');

        static::assertSame('test', $descriptor->getRootNamespace());
    }

    /**
     * @param Descriptor $descriptor Descriptor of bundle who an array representation should be returned
     * @param bool $withParentAndChild If is set to true, includes descriptor of the parent and child bundle (default
     * behaviour). Otherwise - not.
     * @param array $expected Expected array
     *
     * @dataProvider provideArrayFromDescriptor
     */
    public function testToArray(Descriptor $descriptor, bool $withParentAndChild, array $expected): void
    {
        static::assertSame($expected, $descriptor->toArray($withParentAndChild));
    }
}
