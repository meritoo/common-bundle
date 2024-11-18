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
 * @covers    \Meritoo\CommonBundle\Service\ApplicationService
 */
class ApplicationServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private ApplicationService $applicationService;

    /**
     * Provide arguments of constructor and descriptor
     *
     * @return Generator
     */
    public function provideConstructorArgumentsAndDescriptor(): Generator
    {
        $versionFilePath = $this->getFilePathForTesting('VERSION');

        yield [
            $versionFilePath,
            '',
            '',
            new Descriptor('', '', new Version(1, 2, 0)),
        ];

        $versionFilePath = $this->getFilePathForTesting('VERSION_ANOTHER');

        yield [
            $versionFilePath,
            'Lorem',
            'Sed posuere consectetur est at lobortis',
            new Descriptor(
                'Lorem',
                'Sed posuere consectetur est at lobortis',
                new Version(5, 46, 17),
            ),
        ];
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            ApplicationService::class,
            OopVisibility::Public,
            3,
            3,
        );
    }

    public function testConstructorUsingEmptyVersionFilePath(): void
    {
        $message = 'Path of a file, who contains version of the application, is empty. Is there everything ok?';

        $this->expectException(EmptyVersionFilePathException::class);
        $this->expectExceptionMessage($message);

        new ApplicationService('', '', '');
    }

    public function testConstructorUsingUnreadableVersionFilePath(): void
    {
        $message = 'File nibh/purus/porta/malesuada/VERSION, who contains version of the application, is not readable.'
            .' Does the file exist?';

        $this->expectException(UnreadableVersionFileException::class);
        $this->expectExceptionMessage($message);

        new ApplicationService('nibh/purus/porta/malesuada/VERSION', '', '');
    }

    /**
     * @param string $versionFilePath Path of a file who contains version of the application
     * @param null|string $applicationName Name of application. May be displayed near logo.
     * @param null|string $applicationDescription Description of application. May be displayed near logo.
     * @param Descriptor $expected Expected descriptor of application
     *
     * @dataProvider provideConstructorArgumentsAndDescriptor
     */
    public function testGetDescriptor(
        string $versionFilePath,
        ?string $applicationName,
        ?string $applicationDescription,
        Descriptor $expected,
    ): void {
        $service = new ApplicationService($versionFilePath, $applicationName, $applicationDescription);
        static::assertEquals($expected, $service->getDescriptor());
    }

    public function testGetDescriptorUsingTestEnvironment(): void
    {
        $expected = new Descriptor(
            'This is a Test',
            'Just for Testing',
            new Version(1, 2, 0),
        );

        static::assertEquals($expected, $this->applicationService->getDescriptor());
    }

    public function testGetVersionUsingDefaults(): void
    {
        $this->expectException(UnreadableVersionFileException::class);

        static::bootKernel([
            'environment' => 'default',
        ]);

        static::getContainer()
            ->get(ApplicationService::class)
            ->getDescriptor()
            ->getVersion()
        ;
    }

    public function testGetVersionUsingTestEnvironment(): void
    {
        $expected = new Version(1, 2, 0);

        $version = $this->applicationService
            ->getDescriptor()
            ->getVersion()
        ;

        static::assertEquals($expected, $version);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var ApplicationService $applicationService */
        $applicationService = static::getContainer()->get(ApplicationService::class);

        $this->applicationService = $applicationService;
    }
}
