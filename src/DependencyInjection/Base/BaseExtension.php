<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\DependencyInjection\Base;

use Meritoo\Common\Utilities\Arrays;
use Meritoo\Common\Utilities\Miscellaneous;
use Meritoo\CommonBundle\DependencyInjection\ConfigurationFile\FileLoaderFactory;
use Meritoo\CommonBundle\Enums\Date\ConfigurationFileType;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\FileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * Base Dependency Injection (DI) extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseExtension extends ConfigurableExtension
{
    /**
     * Default extension of configuration files
     *
     * @var ConfigurationFileType
     */
    protected const CONFIGURATION_DEFAULT_EXTENSION = ConfigurationFileType::YAML;

    /**
     * Path of directory with configuration files (located in bundle's resources)
     *
     * @var string
     */
    protected const CONFIGURATION_PATH = 'Resources/config';

    /**
     * Name of configuration file with services
     *
     * @var string
     */
    protected const CONFIGURATION_SERVICES_NAME = 'services';

    /**
     * Returns path of directory where the bundle exists.
     * It's required to load services from bundle's configuration file.
     *
     * Examples of implementation:
     * -> return Miscellaneous::concatenatePaths(__DIR__, '..');
     * -> return __DIR__ . '..';
     *
     * @return string
     */
    abstract protected function getBundleDirectoryPath(): string;

    /**
     * Returns patterns of keys or paths from configuration that should match to stop loading parameters
     *
     * If matched, the process of building name of parameter is stopped on processed key. To container will load
     * parameter with name where the process was interrupted and with children of those key as value of the parameter.
     *
     * Example:
     * -> keys or paths to stop loading parameters
     * [
     *      'ipsum.sit',
     *      'elit',
     * ];
     *
     * -> configuration
     * [
     *      'lorem' => [
     *          'ipsum' => [
     *              'dolor',
     *              'sit' => [
     *                  'consectetur',
     *                  'adipiscing',
     *              ]
     *          ],
     *          'elit' => [
     *              'tincidunt' => [
     *                  123,
     *                  456,
     *              ]
     *          ]
     *      ]
     * ];
     *
     * -> result
     * [
     *      'lorem.ipsum.0' => 'dolor',
     *      'lorem.ipsum.sit' => [
     *          'consectetur',
     *          'adipiscing',
     *      ],
     *      'lorem.elit' => [
     *          'tincidunt' => [
     *              123,
     *              456,
     *          ]
     *      ]
     * ];
     *
     * @return array
     */
    protected function getKeysToStopLoadingParametersOn(): array
    {
        return [];
    }

    /**
     * Returns name of configuration file with services, e.g. "services.yaml", "services.xml", "services.php".
     * Extensions are defined in Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType class.
     *
     * @return string
     */
    protected function getServicesFileName(): string
    {
        return sprintf('%s.%s', static::CONFIGURATION_SERVICES_NAME, static::CONFIGURATION_DEFAULT_EXTENSION->value);
    }

    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $this
            ->loadParameters($mergedConfig, $container)
            ->loadServices($container)
        ;
    }

    /**
     * Returns name of given configuration file with extension.
     * If the file name does not contain extension, default extension will be used (the ".yaml" extension).
     *
     * @param string $fileName Name of configuration file (with or without extension)
     *
     * @return string
     */
    private function getConfigurationFileWithExtension(string $fileName): string
    {
        $fileExtension = Miscellaneous::getFileExtension($fileName);

        // Use the default extension, if extension of configuration file is unknown
        if (empty($fileExtension)) {
            return Miscellaneous::includeFileExtension($fileName, static::CONFIGURATION_DEFAULT_EXTENSION->value);
        }

        return $fileName;
    }

    /**
     * Returns loader of configuration file
     *
     * @param ContainerBuilder $container Container for the Dependency Injection (DI)
     * @param FileLocator $locator Locator used to find files
     * @param ConfigurationFileType $fileType Type of configuration file
     *
     * @return null|FileLoader
     */
    private function getFileLoader(
        ContainerBuilder $container,
        FileLocator $locator,
        ConfigurationFileType $fileType,
    ): ?FileLoader {
        $loaderFactory = new FileLoaderFactory($container, $locator);

        if (ConfigurationFileType::YAML === $fileType) {
            return $loaderFactory->createYamlFileLoader();
        }

        if (ConfigurationFileType::XML === $fileType) {
            return $loaderFactory->createXmlFileLoader();
        }

        if (ConfigurationFileType::PHP === $fileType) {
            return $loaderFactory->createPhpFileLoader();
        }

        return null;
    }

    /**
     * Returns global patterns of keys or paths from configuration that should match to stop loading parameters
     *
     * @return array
     * @see getKeysToStopLoadingParametersOn() method in this class
     */
    private function getGlobalKeysToStopLoadingParametersOn(): array
    {
        return [
            /*
             * I have to always stop on integer-based keys, the 0-based keys.
             * It's required to proper retrieve / get values that are treated like an array.
             *
             * Example:
             * -> config.yml
             * parameter:
             *      sub-parameter: [value1, value2, value3]
             *
             * -> processed array
             * [
             *      'parameter' => [
             *          'sub-parameter' => [        <------ 0-based indexes
             *              'value1',
             *              'value2',
             *              'value3'
             *          ]
             *      ]
             * ];
             */
            '\d+',
        ];
    }

    /**
     * Loads the configuration file
     *
     * @param ContainerBuilder $container Container for the Dependency Injection (DI)
     * @param string $fileName Name of configuration file. If provided without extension, the default extension of
     * configuration files will be used.
     *
     * @return void
     */
    private function loadConfigurationFile(ContainerBuilder $container, string $fileName): void
    {
        $bundlePath = $this->getBundleDirectoryPath();

        // Unknown path of bundle? Nothing to do
        if (empty($bundlePath)) {
            return;
        }

        $resourcesPath = Miscellaneous::concatenatePaths($bundlePath, static::CONFIGURATION_PATH);
        $filePath = Miscellaneous::concatenatePaths($resourcesPath, $fileName);

        // Configuration file doesn't exist or is not readable? Nothing to do
        if (!is_readable($filePath)) {
            return;
        }

        $fileType = ConfigurationFileType::getTypeFromFileName($fileName);
        $locator = new FileLocator($resourcesPath);

        // Let's load the configuration file
        $fileLoader = $this->getFileLoader($container, $locator, $fileType);

        if (null !== $fileLoader) {
            $fileLoader->load($fileName);
        }
    }

    /**
     * Loads parameters into container
     *
     * @param array $mergedConfig Custom configuration merged with defaults
     * @param ContainerBuilder $container Container for the Dependency Injection (DI)
     *
     * @return BaseExtension
     */
    private function loadParameters(array $mergedConfig, ContainerBuilder $container): BaseExtension
    {
        // No configuration? Nothing to do
        if (empty($mergedConfig)) {
            return $this;
        }

        $flatConfig = $this->makeFlatConfig($mergedConfig);

        if (empty($flatConfig)) {
            return $this;
        }

        /** @var ConfigurationInterface $configuration */
        $configuration = $this->getConfiguration($mergedConfig, $container);

        // Getting slug of bundle's name
        $bundleShortName = $configuration
            ->getConfigTreeBuilder()
            ->buildTree()
            ->getName()
        ;

        foreach ($flatConfig as $name => $value) {
            if (is_string($value)) {
                $value = Miscellaneous::trimSmart($value);
            }

            // Loading parameter into container, prefixed by slug of bundle's name
            $prefixedName = sprintf('%s.%s', $bundleShortName, $name);
            $container->setParameter($prefixedName, $value); // e.g. simple_bundle.foo.bar.something => 'my-value'
        }

        return $this;
    }

    /**
     * Loads services from configuration file (located in bundle's resources)
     *
     * @param ContainerBuilder $container Container for the Dependency Injection (DI)
     *
     * @return void
     */
    private function loadServices(ContainerBuilder $container): void
    {
        $name = $this->getServicesFileName();
        $nameWithExtension = $this->getConfigurationFileWithExtension($name);

        $this->loadConfigurationFile($container, $nameWithExtension);
    }

    /**
     * Makes flat configuration (without nested arrays).
     * Returns an array with key-value pairs, where key - name of parameter, value - value of parameter.
     *
     * @param array $mergedConfig Custom configuration merged with defaults
     *
     * @return null|array
     */
    private function makeFlatConfig(array $mergedConfig): ?array
    {
        // Getting the keys or paths on which building names of parameters should stop
        $keysToStop = $this->getKeysToStopLoadingParametersOn();
        $globalKeysToStop = $this->getGlobalKeysToStopLoadingParametersOn();

        // Merging standard with global keys and paths
        $stopIfMatchedBy = array_merge(
            Arrays::makeArray($keysToStop),
            Arrays::makeArray($globalKeysToStop),
        );

        // Let's get the last elements' paths and load values into container
        return Arrays::getLastElementsPaths($mergedConfig, '.', '', $stopIfMatchedBy);
    }
}
