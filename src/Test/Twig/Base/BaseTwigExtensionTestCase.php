<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Test\Twig\Base;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\DebugExtension;
use Twig\Loader\ArrayLoader;
use Twig\RuntimeLoader\ContainerRuntimeLoader;

/**
 * Base test case for Twig extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseTwigExtensionTestCase extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor($this->getExtensionNamespace());
    }

    /**
     * Returns instance of Twig extension to verify
     *
     * @return AbstractExtension
     */
    protected function getExtensionInstance(): AbstractExtension
    {
        $namespace = $this->getExtensionNamespace();

        return new $namespace();
    }

    /**
     * Returns namespace of Twig extension to verify
     *
     * @return string
     */
    abstract protected function getExtensionNamespace(): string;

    /**
     * Returns instance of the Twig Environment
     *
     * @param array $templates (optional) Templates who should be available for the Twig Environment. Key-value pairs,
     *                         where: key - name, value - source code of template.
     * @return Environment
     */
    protected function getTwigEnvironment(array $templates = []): Environment
    {
        $isDebugEnabled = static::$container->getParameter('kernel.debug');

        $loader = new ArrayLoader($templates);
        $twigEnvironment = new Environment($loader, ['debug' => $isDebugEnabled]);

        $twigEnvironment->addExtension($this->getExtensionInstance());
        $twigEnvironment->addRuntimeLoader(new ContainerRuntimeLoader(static::$container));

        if ($isDebugEnabled) {
            $twigEnvironment->addExtension(new DebugExtension());
        }

        return $twigEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }

    /**
     * Verifies template with given source code
     *
     * @param string $name       Name of the rendered template (used internally only)
     * @param string $sourceCode Source code of the rendered template
     * @param mixed  $expected   Expected result of rendering
     */
    protected function verifyRenderedTemplate(string $name, string $sourceCode, $expected): void
    {
        $templates = [
            $name => $sourceCode,
        ];

        $rendered = $this
            ->getTwigEnvironment($templates)
            ->render($name);

        static::assertSame($expected, $rendered);
    }
}
