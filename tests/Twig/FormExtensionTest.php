<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Twig\FormExtension;
use Meritoo\CommonBundle\Twig\FormRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\TwigFunction;

/**
 * Test case for the Twig extension related to the FormService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormExtensionTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(FormExtension::class);
    }

    public function testGetFunctions(): void
    {
        $functions = static::$container
            ->get(FormExtension::class)
            ->getFunctions();

        /* @var TwigFunction $isHtml5ValidationEnabledFunction */
        $isHtml5ValidationEnabledFunction = $functions[0];

        static::assertCount(1, $functions);
        static::assertInstanceOf(TwigFunction::class, $isHtml5ValidationEnabledFunction);
        static::assertSame('meritoo_common_form_is_html5_validation_enabled', $isHtml5ValidationEnabledFunction->getName());
        static::assertSame([
            FormRuntime::class,
            'isHtml5ValidationEnabled',
        ], $isHtml5ValidationEnabledFunction->getCallable());
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
