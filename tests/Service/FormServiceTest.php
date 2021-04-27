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
 * Test case for the service that serves form
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Service\FormService
 */
class FormServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            FormService::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    public function testIsHtml5ValidationEnabledUsingTestEnvironment(): void
    {
        $enabled = static::$container
            ->get(FormService::class)
            ->isHtml5ValidationEnabled()
        ;

        static::assertFalse($enabled);
    }

    public function testIsHtml5ValidationEnabledUsingDefaults(): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $enabled = static::$container
            ->get(FormService::class)
            ->isHtml5ValidationEnabled()
        ;

        static::assertTrue($enabled);
    }

    /**
     * @param array $existingOptions Existing options
     * @param array $expected        Expected options
     *
     * @dataProvider provideExistingFormOptionsUsingDefaults
     */
    public function testAddFormOptionsUsingTestEnvironment(array $existingOptions, array $expected): void
    {
        static::$container
            ->get(FormService::class)
            ->addHtml5ValidationOptions($existingOptions)
        ;

        static::assertSame($expected, $existingOptions);
    }

    /**
     * @param array $existingOptions Existing options
     * @param array $expected        Expected options
     *
     * @dataProvider provideExistingFormOptionsCustomConfiguration
     */
    public function testAddFormOptionsUsingDefaults(array $existingOptions, array $expected): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        static::$container
            ->get(FormService::class)
            ->addHtml5ValidationOptions($existingOptions)
        ;

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
     * Provides existing form options while using values loaded from custom configuration
     *
     * @return Generator
     */
    public function provideExistingFormOptionsCustomConfiguration(): Generator
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
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }
}
