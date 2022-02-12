<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Meritoo\CommonBundle\Application;

use Meritoo\Common\ValueObject\Version;
use Meritoo\CommonBundle\Application\Descriptor;
use PhpSpec\ObjectBehavior;

class DescriptorSpec extends ObjectBehavior
{
    public function it_has_description(): void
    {
        $this->getDescription()->shouldReturn('test of description')
        ;
    }

    public function it_has_name(): void
    {
        $this->getName()->shouldReturn('test of name')
        ;
    }

    public function it_has_version(): void
    {
        $this->getVersion()->shouldBeLike(new Version(1, 0, 1))
        ;
    }

    public function it_is_convertible_to_string(): void
    {
        $this->__toString()->shouldReturn('test of name | test of description | 1.0.1')
        ;
    }

    public function it_is_convertible_to_string_without_description(): void
    {
        $this->beConstructedWith('test of name', '', new Version(1, 0, 1));
        $this->__toString()->shouldReturn('test of name | - | 1.0.1')
        ;
    }

    public function it_is_convertible_to_string_without_name(): void
    {
        $this->beConstructedWith('', 'test of description', new Version(1, 0, 1));
        $this->__toString()->shouldReturn('- | test of description | 1.0.1')
        ;
    }

    public function it_is_convertible_to_string_without_version(): void
    {
        $this->beConstructedWith('test of name', 'test of description', null);
        $this->__toString()->shouldReturn('test of name | test of description | -')
        ;
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(Descriptor::class);
    }

    public function let(): void
    {
        $this->beConstructedWith('test of name', 'test of description', new Version(1, 0, 1));
    }
}
