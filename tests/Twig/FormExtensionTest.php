<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase;
use Meritoo\CommonBundle\Twig\FormExtension;

/**
 * Test case for the Twig extension related to the FormService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\FormExtension
 * @covers    \Meritoo\CommonBundle\Test\Twig\Base\BaseTwigExtensionTestCase
 */
class FormExtensionTest extends BaseTwigExtensionTestCase
{
    public function testGetFunctions(): void
    {
        static::assertCount(1, $this->twigExtension->getFunctions());
    }

    public function testIsHtml5ValidationEnabledUsingDefaults(): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $name = 'is_html5_validation_enabled';
        $sourceCode = '{{ dump(meritoo_common_form_is_html5_validation_enabled()) }}';

        $templates = [
            $name => $sourceCode,
        ];

        $rendered = $this
            ->getTwigEnvironment($templates)
            ->render($name)
        ;

        static::assertMatchesRegularExpression('/bool\(true\)/', $rendered);
    }

    public function testIsHtml5ValidationEnabledUsingTestEnvironment(): void
    {
        $name = 'is_html5_validation_enabled';
        $sourceCode = '{{ dump(meritoo_common_form_is_html5_validation_enabled()) }}';

        $templates = [
            $name => $sourceCode,
        ];

        $rendered = $this
            ->getTwigEnvironment($templates)
            ->render($name)
        ;

        static::assertMatchesRegularExpression('/bool\(false\)/', $rendered);
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensionNamespace(): string
    {
        return FormExtension::class;
    }
}
