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
use Meritoo\CommonBundle\Twig\FormRuntime;
use Twig\TwigFunction;

/**
 * Test case for the Twig extension related to the FormService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormExtensionTest extends BaseTwigExtensionTestCase
{
    public function testGetFunctions(): void
    {
        $functions = static::$container
            ->get($this->getExtensionNamespace())
            ->getFunctions();

        $filters = static::$container
            ->get($this->getExtensionNamespace())
            ->getFilters();

        /* @var TwigFunction $isHtml5ValidationEnabledFunction */
        $isHtml5ValidationEnabledFunction = $functions[0];

        static::assertCount(1, $functions);
        static::assertCount(0, $filters);

        static::assertInstanceOf(TwigFunction::class, $isHtml5ValidationEnabledFunction);
        static::assertSame('meritoo_common_form_is_html5_validation_enabled', $isHtml5ValidationEnabledFunction->getName());
        static::assertSame([
            FormRuntime::class,
            'isHtml5ValidationEnabled',
        ], $isHtml5ValidationEnabledFunction->getCallable());
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
            ->render($name);

        static::assertRegExp('/bool\(false\)/', $rendered);
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
            ->render($name);

        static::assertRegExp('/bool\(true\)/', $rendered);
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtensionNamespace(): string
    {
        return FormExtension::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
    }
}
