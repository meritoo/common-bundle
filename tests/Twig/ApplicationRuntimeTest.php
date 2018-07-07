<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\Common\ValueObject\Version;
use Meritoo\CommonBundle\Application\Descriptor;
use Meritoo\CommonBundle\Twig\ApplicationRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the runtime class related to ApplicationExtension Twig Extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationRuntimeTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(ApplicationRuntime::class, OopVisibilityType::IS_PUBLIC, 1, 1);
    }

    public function testGetDescriptor(): void
    {
        $expected = new Descriptor('', '', new Version(1, 2, 0));

        $descriptor = static::$container
            ->get(ApplicationRuntime::class)
            ->getDescriptor();

        static::assertEquals($expected, $descriptor);
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
