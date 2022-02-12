<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Generator;
use Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase;
use Meritoo\CommonBundle\Twig\CommonExtension;

/**
 * Test case for the twig extension that provides functions and filters for common operations
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\CommonExtension
 */
class CommonExtensionTest extends BaseTwigExtensionTestCase
{
    /**
     * Provide template for filter empty value (using default configuration)
     *
     * @return Generator
     */
    public function provideTemplateForFilterEmptyValueUsingDefaults(): Generator
    {
        yield [
            'filter_null',
            '{{ null | meritoo_common_empty_value }}',
            '-',
        ];

        yield [
            'filter_iterable',
            '{{ [] | meritoo_common_empty_value }}',
            '-',
        ];

        yield [
            'filter_iterable',
            '{{ {} | meritoo_common_empty_value }}',
            '-',
        ];

        yield [
            'filter_string',
            '{{ "" | meritoo_common_empty_value }}',
            '-',
        ];

        yield [
            'filter_not_null',
            '{{ {1: "test 1", 2: "test 2"} | meritoo_common_empty_value | length }}',
            '2',
        ];

        yield [
            'filter_not_empty_iterable',
            '{{ {test1: 1, test2: 2, test3: 3} | meritoo_common_empty_value | length }}',
            '3',
        ];

        yield [
            'filter_not_empty_string',
            '{{ "test" | meritoo_common_empty_value }}',
            'test',
        ];
    }

    /**
     * Provide template for filter empty value (using "test" environment)
     *
     * @return Generator
     */
    public function provideTemplateForFilterEmptyValueUsingTestEnvironment(): Generator
    {
        yield [
            'filter_null',
            '{{ null | meritoo_common_empty_value }}',
            '...',
        ];

        yield [
            'filter_iterable',
            '{{ [] | meritoo_common_empty_value }}',
            '...',
        ];

        yield [
            'filter_iterable',
            '{{ {} | meritoo_common_empty_value }}',
            '...',
        ];

        yield [
            'filter_string',
            '{{ "" | meritoo_common_empty_value }}',
            '...',
        ];

        yield [
            'filter_not_null',
            '{{ {1: "test 1", 2: "test 2"} | meritoo_common_empty_value | length }}',
            '2',
        ];

        yield [
            'filter_not_empty_iterable',
            '{{ {test1: 1, test2: 2, test3: 3} | meritoo_common_empty_value | length }}',
            '3',
        ];

        yield [
            'filter_not_empty_string',
            '{{ "test" | meritoo_common_empty_value }}',
            'test',
        ];
    }

    /**
     * @param string $name       Name of the rendered template (used internally only)
     * @param string $sourceCode Source code of the rendered template
     * @param mixed  $expected   Expected result of rendering
     *
     * @dataProvider provideTemplateForFilterEmptyValueUsingDefaults
     */
    public function testFilterEmptyValueUsingDefaults(string $name, string $sourceCode, $expected): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $this->verifyRenderedTemplate($name, $sourceCode, $expected);
    }

    /**
     * @param string $name       Name of the rendered template (used internally only)
     * @param string $sourceCode Source code of the rendered template
     * @param mixed  $expected   Expected result of rendering
     *
     * @dataProvider provideTemplateForFilterEmptyValueUsingTestEnvironment
     */
    public function testFilterEmptyValueUsingTestEnvironment(string $name, string $sourceCode, $expected): void
    {
        $this->verifyRenderedTemplate($name, $sourceCode, $expected);
    }

    public function testGetFilters(): void
    {
        $filters = static::$container
            ->get($this->getExtensionNamespace())
            ->getFilters();

        static::assertCount(1, $filters);
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensionNamespace(): string
    {
        return CommonExtension::class;
    }
}
