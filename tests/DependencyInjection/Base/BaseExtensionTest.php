<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\Base;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\EmptyBundlePath\Extension as EmptyBundlePathExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\NotExistingServicesFile\Extension as NotExistingServicesFileExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\PhpServicesFileType\Extension as PhpServicesFileTypeExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\UnknownServicesFileType\Extension as UnknownServicesFileTypeExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\WithoutParameters\Extension as WithoutParametersExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\XmlServicesFileType\Extension as XmlServicesFileTypeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Test case of base Dependency Injection (DI) extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension
 */
class BaseExtensionTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertHasNoConstructor(BaseExtension::class);
    }

    public function testLoadingParametersWithUnknownServicesFileType(): void
    {
        $message = 'The \'txt\' type of Dependency Injection (DI) configuration file is unknown. Probably doesn\'t'
            . ' exist or there is a typo. You should use one of these types: php, xml, yaml.';

        $this->expectException(UnknownConfigurationFileTypeException::class);
        $this->expectExceptionMessage($message);

        $container = new ContainerBuilder();
        $extension = new UnknownServicesFileTypeExtension();

        $configuration = [];
        $extension->load($configuration, $container);
    }

    /**
     * @param BaseExtension $extension The extension
     *
     * @dataProvider provideExtension
     */
    public function testLoadingParametersAndServices(BaseExtension $extension): void
    {
        $configuration = [];
        $container = new ContainerBuilder();

        $extension->load($configuration, $container);
        static::assertCount(0, $container->getParameterBag()->all());

        /*
         * There are 3 default services:
         * -> "service_container"
         * -> "Psr\Container\ContainerInterface"
         * -> "Symfony\Component\DependencyInjection\ContainerInterface"
         */
        static::assertCount(3, $container->getServiceIds());
    }

    /**
     * Provides extension
     *
     * @return \Generator
     */
    public function provideExtension(): \Generator
    {
        yield[
            new EmptyBundlePathExtension(),
        ];

        yield[
            new WithoutParametersExtension(),
        ];

        yield[
            new NotExistingServicesFileExtension(),
        ];

        yield[
            new XmlServicesFileTypeExtension(),
        ];

        yield[
            new PhpServicesFileTypeExtension(),
        ];
    }
}
