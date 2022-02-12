<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Meritoo\CommonBundle\Bundle;

use Meritoo\Common\Collection\BaseCollection;
use Meritoo\CommonBundle\Bundle\Descriptor;
use Meritoo\CommonBundle\Bundle\Descriptors;
use PhpSpec\ObjectBehavior;

class DescriptorsSpec extends ObjectBehavior
{
    public function is_a_collection(): void
    {
        $this->shouldBeAnInstanceOf(BaseCollection::class);
    }

    public function it_has_descriptor_when_root_namespace_is_empty(): void
    {
        $descriptors = $this->getDescriptors();

        $this
            ->getDescriptor('')
            ->shouldBeLike($descriptors['without_root_namespace'])
        ;
    }

    public function it_has_descriptor_when_root_namespace_matches_given(): void
    {
        $descriptors = $this->getDescriptors();

        $this
            ->getDescriptor('Test\Namespace2\ClassName')
            ->shouldBeLike($descriptors['descriptor2'])
        ;
    }

    public function it_has_descriptor_with_given_name_of_bundle(): void
    {
        $descriptors = $this->getDescriptors();

        $this
            ->getDescriptorByName('Test1')
            ->shouldBeLike($descriptors['descriptor1'])
        ;
    }

    public function it_has_not_descriptor(): void
    {
        $this->getDescriptor('Test\Namespace\ClassName')->shouldBeNull()
        ;
    }

    public function it_has_not_descriptor_with_given_name_of_bundle(): void
    {
        $this
            ->getDescriptorByName('Test3')
            ->shouldBeNull()
        ;
    }

    public function it_is_convertible_to_an_empty_array_when_there_are_no_descriptors(): void
    {
        $this->beConstructedWith([]);

        $this
            ->toArray()
            ->shouldReturn([])
        ;
    }

    public function it_is_convertible_to_array(): void
    {
        $this
            ->toArray()
            ->shouldReturn([
                '' => [
                    'name' => 'Test',
                    'shortName' => 'test',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
                'Test\Namespace1' => [
                    'name' => 'Test1',
                    'shortName' => 'test1',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Test\Namespace1',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
                'Test\Namespace2' => [
                    'name' => 'Test2',
                    'shortName' => 'test2',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Test\Namespace2',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
            ])
        ;
    }

    public function it_is_created_from_an_array(): void
    {
        $descriptors = new Descriptors($this->getDescriptors());

        $this
            ->fromArray([
                '' => [
                    'name' => 'Test',
                    'shortName' => 'test',
                    'configurationRootName' => '',
                    'rootNamespace' => '',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
                'Test\Namespace1' => [
                    'name' => 'Test1',
                    'shortName' => 'test1',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Test\Namespace1',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
                'Test\Namespace2' => [
                    'name' => 'Test2',
                    'shortName' => 'test2',
                    'configurationRootName' => '',
                    'rootNamespace' => 'Test\Namespace2',
                    'path' => '',
                    'dataFixtures' => [
                    ],
                ],
            ])
            ->shouldBeLike($descriptors)
        ;
    }

    public function it_is_created_from_an_empty_array(): void
    {
        $this
            ->fromArray([])
            ->shouldBeLike(new Descriptors())
        ;
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Descriptors::class);
    }

    public function let(): void
    {
        $this->beConstructedWith($this->getDescriptors());
    }

    private function getDescriptors(): array
    {
        return [
            'empty' => new Descriptor(),
            'without_root_namespace' => new Descriptor('Test', '', ''),
            'descriptor1' => new Descriptor('Test1', '', 'Test\Namespace1'),
            'descriptor2' => new Descriptor('Test2', '', 'Test\Namespace2'),
        ];
    }
}
