<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Service\FormService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the service who serves form
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(FormService::class, OopVisibilityType::IS_PUBLIC, 1, 1);
    }

    public function testIsHtml5ValidationEnabledUsingDefaults(): void
    {
        $enabled = static::$container
            ->get(FormService::class)
            ->isHtml5ValidationEnabled();

        static::assertFalse($enabled);
    }

    public function testIsHtml5ValidationEnabledUsingDependencyInjection(): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $enabled = static::$container
            ->get(FormService::class)
            ->isHtml5ValidationEnabled();

        static::assertTrue($enabled);
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
