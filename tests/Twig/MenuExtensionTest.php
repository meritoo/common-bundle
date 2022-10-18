<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase;
use Meritoo\CommonBundle\Twig\MenuExtension;

/**
 * Test case for the Twig extension related to menu
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\MenuExtension
 * @covers    \Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase
 */
class MenuExtensionTest extends BaseTwigExtensionTestCase
{
    public function testGetFunctions(): void
    {
        static::assertCount(1, $this->twigExtension->getFunctions());
    }

    public function testIsActive(): void
    {
        $name = 'is_active';
        $sourceCode = "{{ dump(meritoo_common_menu_is_active('/test', 'test_route')) }}";

        $templates = [
            $name => $sourceCode,
        ];

        $rendered = $this
            ->getTwigEnvironment($templates)
            ->render($name)
        ;

        static::assertMatchesRegularExpression('/bool\(false\)/', $rendered);
    }

    protected function getExtensionNamespace(): string
    {
        return MenuExtension::class;
    }
}
