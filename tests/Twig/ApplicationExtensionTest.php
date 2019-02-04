<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase;
use Meritoo\CommonBundle\Twig\ApplicationExtension;
use Twig\Error\RuntimeError;

/**
 * Test case for the Twig extension related to the ApplicationService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @coversNothing
 */
class ApplicationExtensionTest extends BaseTwigExtensionTestCase
{
    public function testGetFunctions(): void
    {
        $functions = static::$container
            ->get($this->getExtensionNamespace())
            ->getFunctions()
        ;

        static::assertCount(1, $functions);
    }

    /**
     * @param string $name       Name of the rendered template (used internally only)
     * @param string $sourceCode Source code of the rendered template
     * @param string $expected   Expected result of rendering
     *
     * @dataProvider provideTemplateForGetDescriptor
     */
    public function testGetDescriptorUsingTestEnvironment(string $name, string $sourceCode, string $expected): void
    {
        $this->verifyRenderedTemplate($name, $sourceCode, $expected);
    }

    public function testGetDescriptorUsingDefaults(): void
    {
        $this->expectException(RuntimeError::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $this->verifyRenderedTemplate(
            'anything',
            '{{ meritoo_common_application_descriptor() }}',
            'anything'
        );
    }

    /**
     * Provides templates for the "get descriptor" function
     *
     * @return \Generator
     */
    public function provideTemplateForGetDescriptor(): \Generator
    {
        yield[
            'descriptor_as_string',
            '{{ meritoo_common_application_descriptor() }}',
            'This is a Test | Just for Testing | 1.2.0',
        ];

        yield[
            'app_name_from_descriptor',
            '{{ meritoo_common_application_descriptor().name }}',
            'This is a Test',
        ];

        yield[
            'app_description_from_descriptor',
            '{{ meritoo_common_application_descriptor().description }}',
            'Just for Testing',
        ];

        yield[
            'app_version_from_descriptor',
            '{{ meritoo_common_application_descriptor().version }}',
            '1.2.0',
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensionNamespace(): string
    {
        return ApplicationExtension::class;
    }
}
