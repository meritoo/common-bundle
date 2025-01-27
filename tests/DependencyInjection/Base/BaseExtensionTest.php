<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\Base;

use Generator;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\EmptyBundlePath\Extension as EmptyBundlePathExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\NotExistingServicesFile\Extension as NotExistingServicesFileExtension;
use Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\PhpServicesFileType\Extension as PhpServicesFileTypeExtension;
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
 * @covers    \Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension
 */
class BaseExtensionTest extends BaseTestCase
{
    /**
     * Provides extension
     *
     * @return Generator
     */
    public function provideExtension(): Generator
    {
        yield [
            new EmptyBundlePathExtension(),
        ];

        yield [
            new WithoutParametersExtension(),
        ];

        yield [
            new NotExistingServicesFileExtension(),
        ];

        yield [
            new XmlServicesFileTypeExtension(),
        ];

        yield [
            new PhpServicesFileTypeExtension(),
        ];
    }

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(BaseExtension::class);
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
        static::assertCount(1, $container->getServiceIds());
    }
}
