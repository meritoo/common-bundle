<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\ConfigurationFile;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\DependencyInjection\ConfigurationFile\FileLoaderFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Test case of factory for the loader of configuration file
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\DependencyInjection\ConfigurationFile\FileLoaderFactory
 */
class FileLoaderFactoryTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            FileLoaderFactory::class,
            OopVisibilityType::IS_PUBLIC,
            2,
            2
        );
    }

    public function testCreateYamlFileLoader(): void
    {
        $container = new ContainerBuilder();
        $locator = new FileLocator('');
        $factory = new FileLoaderFactory($container, $locator);

        static::assertEquals(new YamlFileLoader($container, $locator), $factory->createYamlFileLoader());
    }

    public function testCreatePhpFileLoader(): void
    {
        $container = new ContainerBuilder();
        $locator = new FileLocator('');
        $factory = new FileLoaderFactory($container, $locator);

        static::assertEquals(new PhpFileLoader($container, $locator), $factory->createPhpFileLoader());
    }

    public function testCreateXmlFileLoader(): void
    {
        $container = new ContainerBuilder();
        $locator = new FileLocator('');
        $factory = new FileLoaderFactory($container, $locator);

        static::assertEquals(new XmlFileLoader($container, $locator), $factory->createXmlFileLoader());
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
