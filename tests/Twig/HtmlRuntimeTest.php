<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Twig\HtmlRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Test case for the runtime class related to HtmlExtension Twig Extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\HtmlRuntime
 */
class HtmlRuntimeTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private HtmlRuntime $htmlRuntime;

    public function provideAttributes(): \Generator
    {
        yield 'Empty array' => [
            [],
            null,
        ];

        yield 'Non empty' => [
            ['test1' => 'lorem', 'test2' => 'ipsum'],
            'test1="lorem" test2="ipsum"',
        ];
    }

    /**
     * @dataProvider provideAttributes
     */
    public function testAttributes2string(array $attributes, ?string $expected): void
    {
        static::assertSame($expected, $this->htmlRuntime->attributes2string($attributes));
    }

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(HtmlRuntime::class);
    }

    public function testIsInstanceOfRuntimeExtensionInterface(): void
    {
        static::assertInstanceOf(RuntimeExtensionInterface::class, $this->htmlRuntime);
    }

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var HtmlRuntime $htmlRuntime */
        $htmlRuntime = static::getContainer()->get(HtmlRuntime::class);

        $this->htmlRuntime = $htmlRuntime;
    }
}
