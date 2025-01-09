<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
use Meritoo\Common\Enums\OopVisibility;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Contract\Service\FormServiceInterface;
use Meritoo\CommonBundle\Service\FormService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Util\OrderedHashMap;

/**
 * Test case for the service that serves form
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Service\FormService
 */
class FormServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private FormService $formService;

    /**
     * Provides existing form options while using values loaded from custom configuration
     *
     * @return Generator
     */
    public function provideExistingFormOptionsCustomConfiguration(): Generator
    {
        yield [
            [],
            [],
        ];

        yield [
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
     * Provides existing form options while using default values
     *
     * @return Generator
     */
    public function provideExistingFormOptionsUsingDefaults(): Generator
    {
        yield [
            [],
            [
                'attr' => [
                    'novalidate' => 'novalidate',
                ],
            ],
        ];

        yield [
            [
                'option1' => 'value1',
                'option2' => 'value2',
            ],
            [
                'option1' => 'value1',
                'option2' => 'value2',
                'attr' => [
                    'novalidate' => 'novalidate',
                ],
            ],
        ];
    }

    /**
     * @param array $existingOptions Existing options
     * @param array $expected Expected options
     *
     * @dataProvider provideExistingFormOptionsCustomConfiguration
     */
    public function testAddHtml5ValidationOptionsUsingDefaults(array $existingOptions, array $expected): void
    {
        static::bootKernel([
            'environment' => 'default',
        ]);

        static::getContainer()
            ->get(FormServiceInterface::class)
            ->addHtml5ValidationOptions($existingOptions)
        ;

        static::assertSame($expected, $existingOptions);
    }

    /**
     * @param array $existingOptions Existing options
     * @param array $expected Expected options
     *
     * @dataProvider provideExistingFormOptionsUsingDefaults
     */
    public function testAddHtml5ValidationOptionsUsingTestEnvironment(array $existingOptions, array $expected): void
    {
        $this->formService->addHtml5ValidationOptions($existingOptions);
        static::assertSame($expected, $existingOptions);
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            FormService::class,
            OopVisibility::Public,
            1,
            1,
        );
    }

    public function testErrorsToArrayIfFormAndFieldsHaveErrors(): void
    {
        /** @var FormServiceInterface $service */
        $service = static::getContainer()->get(FormServiceInterface::class);

        $field1 = $this->createMock(FormInterface::class);
        $field2 = $this->createMock(FormInterface::class);
        $field3 = $this->createMock(FormInterface::class);

        $form = $this->createConfiguredMock(Form::class, [
            'getIterator' => new OrderedHashMap([$field1, $field2, $field3]),
        ]);

        $field1Errors = new FormErrorIterator($form, [
            new FormError('Error 1', null, [], null, 'test-field-1'),
        ]);

        $field2Errors = new FormErrorIterator($form, [
            new FormError('Error 2', null, [], null, 'test-field-2'),
        ]);

        $field3Errors = new FormErrorIterator($form, [
            new FormError('Error 3', null, [], null, 'test-field-3'),
        ]);

        $field1
            ->expects(self::once())
            ->method('getName')
            ->willReturn('test-field-1')
        ;

        $field1
            ->expects(self::once())
            ->method('getErrors')
            ->willReturn($field1Errors)
        ;

        $field2
            ->expects(self::once())
            ->method('getName')
            ->willReturn('test-field-2')
        ;

        $field2
            ->expects(self::once())
            ->method('getErrors')
            ->willReturn($field2Errors)
        ;

        $field3
            ->expects(self::once())
            ->method('getName')
            ->willReturn('test-field-3')
        ;

        $field3
            ->expects(self::once())
            ->method('getErrors')
            ->willReturn($field3Errors)
        ;

        $errors = new FormErrorIterator($form, [
            new FormError('Global error 1'),
            new FormError('Global error 2'),
        ]);

        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(false)
        ;

        $form
            ->expects(self::once())
            ->method('getName')
            ->willReturn('test-form')
        ;

        $form
            ->expects(self::once())
            ->method('getErrors')
            ->willReturn($errors)
        ;

        $expected = [
            'test-form' => [
                'Global error 1',
                'Global error 2',
            ],
            'test-field-1' => [
                'Error 1',
            ],
            'test-field-2' => [
                'Error 2',
            ],
            'test-field-3' => [
                'Error 3',
            ],
        ];

        $result = $service->errorsToArray($form);
        self::assertSame($expected, $result);
    }

    public function testErrorsToArrayIfFormHasGlobalErrorsOnly(): void
    {
        /** @var FormServiceInterface $service */
        $service = static::getContainer()->get(FormServiceInterface::class);

        $field1 = $this->createMock(FormInterface::class);
        $field2 = $this->createMock(FormInterface::class);
        $field3 = $this->createMock(FormInterface::class);

        $form = $this->createConfiguredMock(Form::class, [
            'getIterator' => new OrderedHashMap([$field1, $field2, $field3]),
        ]);

        $field1
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true)
        ;

        $field2
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true)
        ;

        $field3
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true)
        ;

        $errors = new FormErrorIterator($form, [
            new FormError('Global error 1'),
            new FormError('Global error 2'),
        ]);

        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(false)
        ;

        $form
            ->expects(self::once())
            ->method('getName')
            ->willReturn('test-form')
        ;

        $form
            ->expects(self::once())
            ->method('getErrors')
            ->willReturn($errors)
        ;

        $expected = [
            'test-form' => [
                'Global error 1',
                'Global error 2',
            ],
        ];

        $result = $service->errorsToArray($form);
        self::assertSame($expected, $result);
    }

    public function testErrorsToArrayIfFormIsValid(): void
    {
        /** @var FormServiceInterface $service */
        $service = static::getContainer()->get(FormServiceInterface::class);
        $form = $this->createMock(FormInterface::class);

        $form
            ->expects(self::once())
            ->method('isValid')
            ->willReturn(true)
        ;

        $result = $service->errorsToArray($form);
        self::assertSame([], $result);
    }

    public function testIsHtml5ValidationEnabledUsingDefaults(): void
    {
        static::bootKernel([
            'environment' => 'default',
        ]);

        $enabled = static::getContainer()
            ->get(FormServiceInterface::class)
            ->isHtml5ValidationEnabled()
        ;

        static::assertTrue($enabled);
    }

    public function testIsHtml5ValidationEnabledUsingTestEnvironment(): void
    {
        static::assertFalse($this->formService->isHtml5ValidationEnabled());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var FormService $formService */
        $formService = static::getContainer()->get(FormService::class);

        $this->formService = $formService;
    }
}
