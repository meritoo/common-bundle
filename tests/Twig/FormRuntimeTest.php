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
use Meritoo\CommonBundle\Twig\FormRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Test case for the runtime class related to FormExtension Twig Extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\FormRuntime
 */
class FormRuntimeTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private FormRuntime $formRuntime;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            FormRuntime::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testIsHtml5ValidationEnabled(): void
    {
        static::assertFalse($this->formRuntime->isHtml5ValidationEnabled());
    }

    public function testIsInstanceOfRuntimeExtensionInterface(): void
    {
        static::assertInstanceOf(RuntimeExtensionInterface::class, $this->formRuntime);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var FormRuntime $formRuntime */
        $formRuntime = static::getContainer()->get(FormRuntime::class);

        $this->formRuntime = $formRuntime;
    }
}
