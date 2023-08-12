<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase;
use Meritoo\CommonBundle\Twig\HtmlExtension;

/**
 * Test case for the twig extension that provides functions and filters for html operations
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\HtmlExtension
 * @covers    \Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase
 */
class HtmlExtensionTest extends BaseTwigExtensionTestCase
{
    public function provideAttributes(): \Generator
    {
        yield 'Empty object' => [
            'attributes_2_string_empty_object',
            '{{ {}|meritoo_common_html_attributes_2_string }}',
            '',
        ];

        yield 'Empty array' => [
            'attributes_2_string_empty_array',
            '{{ []|meritoo_common_html_attributes_2_string }}',
            '',
        ];

        yield 'Non empty' => [
            'attributes_2_string_object',
            '{{ {test1: "lorem", test2: "ipsum"}|meritoo_common_html_attributes_2_string }}',
            'test1="lorem" test2="ipsum"',
        ];
    }

    /**
     * @dataProvider provideAttributes
     */
    public function testAttributes2String(string $name, string $sourceCode, string $expected): void
    {
        $this->verifyRenderedTemplate($name, $sourceCode, $expected);
    }

    public function testGetFilters(): void
    {
        static::assertCount(1, $this->twigExtension->getFilters());
    }

    protected function getExtensionNamespace(): string
    {
        return HtmlExtension::class;
    }
}
