<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Type\DependencyInjection;

use Meritoo\Common\Test\Base\BaseTypeTestCase;
use Meritoo\Common\Type\Base\BaseType;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;
use Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType;

/**
 * Test case for the type of Dependency Injection (DI) configuration file
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType
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
            ConfigurationFileType::isCorrectType(''),
            false,
        ];

        yield[
            ConfigurationFileType::isCorrectType(null),
            false,
        ];

        yield[
            ConfigurationFileType::isCorrectType('0'),
            false,
        ];

        yield[
            ConfigurationFileType::isCorrectType('1'),
            false,
        ];

        yield[
            ConfigurationFileType::isCorrectType('jpg'),
            false,
        ];

        yield[
            ConfigurationFileType::isCorrectType('php'),
            true,
        ];

        yield[
            ConfigurationFileType::isCorrectType('xml'),
            true,
        ];

        yield[
            ConfigurationFileType::isCorrectType('yaml'),
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
    protected function getTestedTypeInstance(): BaseType
    {
        return new ConfigurationFileType();
    }
}
