<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
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

    public function testIsHtml5ValidationEnabledUsingCustomConfiguration(): void
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
     * @param array $existingOptions Existing options
     * @param array $expected        Expected options
     *
     * @dataProvider provideExistingFormOptionsUsingDefaults
     */
    public function testAddFormOptionsUsingDefaults(array $existingOptions, array $expected): void
    {
        static::$container
            ->get(FormService::class)
            ->addFormOptions($existingOptions);

        static::assertSame($expected, $existingOptions);
    }

    /**
     * @param array $existingOptions Existing options
     * @param array $expected        Expected options
     *
     * @dataProvider provideExistingFormOptionsCustomConfiguration
     */
    public function testAddFormOptionsUsingCustomConfiguration(array $existingOptions, array $expected): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        static::$container
            ->get(FormService::class)
            ->addFormOptions($existingOptions);

        static::assertSame($expected, $existingOptions);
    }

    /**
     * Provides existing form options while using default values
     *
     * @return Generator
     */
    public function provideExistingFormOptionsUsingDefaults(): Generator
    {
        yield[
            [],
            [],
        ];

        yield[
            [
                'option1' => 'value1',
                'option2' => 'value2',
            ],
            [
                'option1' => 'value1',
                'option2' => 'value2',
            ],
        ];
    }

    /**
     * Provides existing form options while using values loaded from custom configuration
     *
     * @return Generator
     */
    public function provideExistingFormOptionsCustomConfiguration(): Generator
    {
        yield[
            [],
            [
                'attr' => [
                    'novalidate' => 'novalidate',
                ],
            ],
        ];
        yield[
            [
                'option1' => 'value1',
                'option2' => 'value2',
            ],
            [
                'option1' => 'value1',
                'option2' => 'value2',
                'attr'    => [
                    'novalidate' => 'novalidate',
                ],
            ],
        ];
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
