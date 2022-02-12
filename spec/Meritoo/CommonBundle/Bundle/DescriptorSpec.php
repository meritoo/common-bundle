<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Meritoo\CommonBundle\Bundle;

use Meritoo\Common\Collection\StringCollection;
use Meritoo\CommonBundle\Bundle\Descriptor;
use Meritoo\CommonBundle\MeritooCommonBundle;
use PhpSpec\ObjectBehavior;

class DescriptorSpec extends ObjectBehavior
{
    public function it_has_child_bundle_descriptor(): void
    {
        $this->getChildBundleDescriptor()->shouldReturn(null)
        ;
        $value = new Descriptor('ChildBundle', 'ThisIsChild');

        $this->setChildBundleDescriptor($value);
        $this->getChildBundleDescriptor()->shouldReturn($value)
        ;
    }

    public function it_has_configuration_root_name(): void
    {
        $this->getConfigurationRootName()->shouldReturn('')
        ;
        $value = 'TestConfiguration';

        $this->setConfigurationRootName($value);
        $this->getConfigurationRootName()->shouldReturn($value)
        ;
    }

    public function it_has_data_fixtures(): void
    {
        $this->getDataFixtures()->shouldBeLike(new StringCollection())
        ;

        $value = [
            'Data/Fixture1',
            'Data/Fixture2',
        ];

        $this->addDataFixtures($value);
        $this->getDataFixtures()->shouldBeLike(new StringCollection($value))
        ;
    }

    public function it_has_data_fixtures_directory_path(): void
    {
        $this->getDataFixturesDirectoryPath()->shouldBeNull()
        ;
        $value = '/my/test-bundle';

        $this->setPath($value);
        $this->getDataFixturesDirectoryPath()->shouldReturn($value.'/'.Descriptor::PATH_DATA_FIXTURES)
        ;
    }

    public function it_has_file(): void
    {
        $this->hasFile('')->shouldReturn(false)
        ;

        $path = '/my/test-bundle';
        $this->setPath($path);
        $this->hasFile('test/test')->shouldReturn(false)
        ;

        $path = '/my/test-bundle';
        $this->setPath($path);
        $this->hasFile('/my/test-bundle/configuration/routing/authorized.yaml')->shouldReturn(true)
        ;
    }

    public function it_has_name(): void
    {
        $this->getName()->shouldReturn('')
        ;
        $value = 'Test';

        $this->setName($value);
        $this->getName()->shouldReturn($value)
        ;
    }

    public function it_has_parent_bundle_descriptor(): void
    {
        $this->getParentBundleDescriptor()->shouldReturn(null)
        ;
        $value = new Descriptor('ParentBundle', 'ThisIsParent');

        $this->setParentBundleDescriptor($value);
        $this->getParentBundleDescriptor()->shouldReturn($value)
        ;
    }

    public function it_has_path(): void
    {
        $this->getPath()->shouldReturn('')
        ;
        $value = '/my/test-bundle';

        $this->setPath($value);
        $this->getPath()->shouldReturn($value)
        ;
    }

    public function it_has_root_namespace(): void
    {
        $this->getRootNamespace()->shouldReturn('')
        ;
        $value = 'My\\TestBundle';

        $this->setRootNamespace($value);
        $this->getRootNamespace()->shouldReturn($value)
        ;
    }

    public function it_has_short_name(): void
    {
        $this->getShortName()->shouldReturn('')
        ;
    }

    public function it_is_convertible_to_array(): void
    {
        $this
            ->toArray()
            ->shouldReturn([
                'name' => '',
                'shortName' => '',
                'configurationRootName' => '',
                'rootNamespace' => '',
                'path' => '',
                'dataFixtures' => [],
            ])
        ;

        $name = 'Test';
        $configurationRootName = 'TestConfiguration';
        $rootNamespace = 'My\\TestBundle';
        $path = '/my/test-bundle';
        $fixturesPaths = [
            'Data/Fixture1',
            'Data/Fixture2',
        ];

        $this->setName($name);
        $this->setConfigurationRootName($configurationRootName);
        $this->setRootNamespace($rootNamespace);
        $this->setPath($path);
        $this->addDataFixtures($fixturesPaths);
        $this->setParentBundleDescriptor(new Descriptor());
        $this->setChildBundleDescriptor(new Descriptor());

        $this
            ->toArray()
            ->shouldReturn([
                'name' => $name,
                'shortName' => 'test',
                'configurationRootName' => $configurationRootName,
                'rootNamespace' => $rootNamespace,
                'path' => $path,
                'dataFixtures' => $fixturesPaths,
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
            ])
        ;
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Descriptor::class);
    }

    public function it_may_be_created_from_array(): void
    {
        $name = 'Test';
        $configurationRootName = 'TestConfiguration';
        $rootNamespace = 'My\\TestBundle';
        $path = '/my/test-bundle';
        $fixturesPaths = [
            'Data/Fixture1',
            'Data/Fixture2',
        ];

        $this
            ->fromArray([
                'name' => $name,
                'shortName' => 'test',
                'configurationRootName' => $configurationRootName,
                'rootNamespace' => $rootNamespace,
                'path' => $path,
                'dataFixtures' => $fixturesPaths,
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
            ])
            ->shouldBeLike(new Descriptor(
                $name,
                $configurationRootName,
                $rootNamespace,
                $path,
                new Descriptor(),
                new Descriptor()
            ))
        ;
    }

    public function it_may_be_created_from_bundle(): void
    {
        $bundle = new MeritooCommonBundle();

        $this
            ->fromBundle($bundle)
            ->shouldBeLike(new Descriptor(
                'MeritooCommonBundle',
                '',
                'Meritoo\CommonBundle',
                '/var/www/application/src'
            ))
        ;
    }

    public function it_may_be_created_from_empty_array(): void
    {
        $this
            ->fromArray([])
            ->shouldBeLike(new Descriptor())
        ;
    }
}
