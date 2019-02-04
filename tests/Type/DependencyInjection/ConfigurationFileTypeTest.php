<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Type\DependencyInjection;

use Meritoo\Common\Test\Base\BaseTypeTestCase;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;
use Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType;

/**
 * Test case for the type of Dependency Injection (DI) configuration file
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @coversNothing
 */
class ConfigurationFileTypeTest extends BaseTypeTestCase
{
    /**
     * @param string $fileName Name of configuration file
     * @dataProvider provideFileNameWithUnknownExtension
     */
    public function testGetTypeFromFileNameWithUnknownExtension(string $fileName): void
    {
        $this->expectException(UnknownConfigurationFileTypeException::class);
        ConfigurationFileType::getTypeFromFileName($fileName);
    }

    /**
     * @param string $fileName Name of configuration file
     * @param string $expected Expected type of configuration file
     *
     * @dataProvider provideFileNameAndType
     */
    public function testGetTypeFromFileName(string $fileName, string $expected): void
    {
        static::assertSame($expected, ConfigurationFileType::getTypeFromFileName($fileName));
    }

    /**
     * Provides name and type of configuration file
     *
     * @return \Generator
     */
    public function provideFileNameAndType(): \Generator
    {
        yield[
            'example.yaml',
            'yaml',
        ];

        yield[
            'example.xml',
            'xml',
        ];

        yield[
            'example.php',
            'php',
        ];
    }

    /**
     * Provides name of configuration file with unknown extension
     *
     * @return \Generator
     */
    public function provideFileNameWithUnknownExtension(): \Generator
    {
        yield[
            '',
            '',
        ];

        yield[
            '0',
            '',
        ];

        yield[
            'example.jpg',
            '',
        ];

        yield[
            'example.yml',
            '',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function provideTypeToVerify(): \Generator
    {
        yield[
            '',
            false,
        ];

        yield[
            null,
            false,
        ];

        yield[
            0,
            false,
        ];

        yield[
            1,
            false,
        ];

        yield[
            'jpg',
            false,
        ];

        yield[
            'php',
            true,
        ];

        yield[
            'xml',
            true,
        ];

        yield[
            'yaml',
            true,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getAllExpectedTypes(): array
    {
        return [
            'PHP'  => ConfigurationFileType::PHP,
            'XML'  => ConfigurationFileType::XML,
            'YAML' => ConfigurationFileType::YAML,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getTestedTypeInstance(): ConfigurationFileType
    {
        return new ConfigurationFileType();
    }
}
