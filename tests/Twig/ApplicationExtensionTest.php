<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Twig\ApplicationExtension;
use Meritoo\CommonBundle\Twig\ApplicationRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\TwigFunction;

/**
 * Test case for the Twig extension related to the ApplicationService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationExtensionTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(ApplicationExtension::class);
    }

    public function testGetFunctions(): void
    {
        $functions = static::$container
            ->get(ApplicationExtension::class)
            ->getFunctions();

        /* @var TwigFunction $getDescriptorFunction */
        $getDescriptorFunction = $functions[0];

        static::assertCount(1, $functions);
        static::assertInstanceOf(TwigFunction::class, $getDescriptorFunction);
        static::assertSame('meritoo_common_application_descriptor', $getDescriptorFunction->getName());
        static::assertSame([
            ApplicationRuntime::class,
            'getDescriptor',
        ], $getDescriptorFunction->getCallable());
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
