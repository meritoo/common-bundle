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
use Meritoo\Common\ValueObject\Version;
use Meritoo\CommonBundle\Application\Descriptor;
use Meritoo\CommonBundle\Exception\Service\ApplicationService\EmptyVersionFilePathException;
use Meritoo\CommonBundle\Exception\Service\ApplicationService\UnreadableVersionFileException;
use Meritoo\CommonBundle\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the service that serves application
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Service\ApplicationService
 */
class ApplicationServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            ApplicationService::class,
            OopVisibilityType::IS_PUBLIC,
            3,
            3
        );
    }

    public function testConstructorUsingUnreadableVersionFilePath(): void
    {
        $message = 'File nibh/purus/porta/malesuada/VERSION, who contains version of the application, is not readable.'
            . ' Does the file exist?';

        $this->expectException(UnreadableVersionFileException::class);
        $this->expectExceptionMessage($message);

        new ApplicationService('nibh/purus/porta/malesuada/VERSION', '', '');
    }

    public function testConstructorUsingEmptyVersionFilePath(): void
    {
        $message = 'Path of a file, who contains version of the application, is empty. Is there everything ok?';

        $this->expectException(EmptyVersionFilePathException::class);
        $this->expectExceptionMessage($message);

        new ApplicationService('', '', '');
    }

    /**
     * @param string      $versionFilePath        Path of a file who contains version of the application
     * @param null|string $applicationName        Name of application. May be displayed near logo.
     * @param null|string $applicationDescription Description of application. May be displayed near logo.
     * @param Descriptor  $expected               Expected descriptor of application
     *
     * @dataProvider provideConstructorArgumentsAndDescriptor
     */
    public function testGetDescriptor(
        string $versionFilePath,
        ?string $applicationName,
        ?string $applicationDescription,
        Descriptor $expected
    ): void {
        $service = new ApplicationService($versionFilePath, $applicationName, $applicationDescription);
        static::assertEquals($expected, $service->getDescriptor());
    }

    public function testGetDescriptorUsingTestEnvironment(): void
    {
        $expected = new Descriptor(
            'This is a Test',
            'Just for Testing',
            new Version(1, 2, 0)
        );

        $descriptor = static::$container
            ->get(ApplicationService::class)
            ->getDescriptor()
        ;

        static::assertEquals($expected, $descriptor);
    }

    public function testGetVersionUsingDefaults(): void
    {
        $this->expectException(UnreadableVersionFileException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        static::$container
            ->get(ApplicationService::class)
            ->getDescriptor()
            ->getVersion()
        ;
    }

    public function testGetVersionUsingTestEnvironment(): void
    {
        $expected = new Version(1, 2, 0);

        $version = static::$container
            ->get(ApplicationService::class)
            ->getDescriptor()
            ->getVersion()
        ;

        static::assertEquals($expected, $version);
    }

    /**
     * Provide arguments of constructor and descriptor
     *
     * @return \Generator
     */
    public function provideConstructorArgumentsAndDescriptor(): \Generator
    {
        $versionFilePath = $this->getFilePathForTesting('VERSION');

        yield[
            $versionFilePath,
            '',
            '',
            new Descriptor('', '', new Version(1, 2, 0)),
        ];

        $versionFilePath = $this->getFilePathForTesting('VERSION_ANOTHER');

        yield[
            $versionFilePath,
            'Lorem',
            'Sed posuere consectetur est at lobortis',
            new Descriptor(
                'Lorem',
                'Sed posuere consectetur est at lobortis',
                new Version(5, 46, 17)
            ),
        ];
    }
}
