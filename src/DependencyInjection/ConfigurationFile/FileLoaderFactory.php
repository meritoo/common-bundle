<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\DependencyInjection\ConfigurationFile;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Factory for the loader of configuration file
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FileLoaderFactory
{
    /**
     * Container for the Dependency Injection (DI)
     *
     * @var ContainerBuilder
     */
    private ContainerBuilder $container;

    /**
     * Locator used to find files
     *
     * @var FileLocator
     */
    private FileLocator $locator;

    /**
     * Class constructor
     *
     * @param ContainerBuilder $container Container for the Dependency Injection (DI)
     * @param FileLocator      $locator   Locator used to find files
     */
    public function __construct(ContainerBuilder $container, FileLocator $locator)
    {
        $this->container = $container;
        $this->locator = $locator;
    }

    /**
     * Creates and returns loader of configuration file in PHP format
     *
     * @return PhpFileLoader
     */
    public function createPhpFileLoader(): PhpFileLoader
    {
        return new PhpFileLoader($this->container, $this->locator);
    }

    /**
     * Creates and returns loader of configuration file in XML format
     *
     * @return XmlFileLoader
     */
    public function createXmlFileLoader(): XmlFileLoader
    {
        return new XmlFileLoader($this->container, $this->locator);
    }

    /**
     * Creates and returns loader of configuration file in YAML format
     *
     * @return YamlFileLoader
     */
    public function createYamlFileLoader(): YamlFileLoader
    {
        return new YamlFileLoader($this->container, $this->locator);
    }
}
