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
use Meritoo\CommonBundle\Exception\Service\ApplicationService\UnreadableVersionFileException;
use Meritoo\CommonBundle\Twig\ApplicationRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Extension\RuntimeExtensionInterface;

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
        static::assertConstructorVisibilityAndArguments(
            ApplicationRuntime::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testIsInstanceOfRuntimeExtensionInterface(): void
    {
        $runtime = static::$container->get(ApplicationRuntime::class);
        static::assertInstanceOf(RuntimeExtensionInterface::class, $runtime);
    }

    public function testGetDescriptorUsingTestEnvironment(): void
    {
        $expected = new Descriptor(
            'This is a Test',
            'Just for Testing',
            new Version(1, 2, 0)
        );

        $descriptor = static::$container
            ->get(ApplicationRuntime::class)
            ->getDescriptor()
        ;

        static::assertEquals($expected, $descriptor);
    }

    public function testGetDescriptorUsingDefaults(): void
    {
        $this->expectException(UnreadableVersionFileException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        static::$container
            ->get(ApplicationRuntime::class)
            ->getDescriptor()
        ;
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
