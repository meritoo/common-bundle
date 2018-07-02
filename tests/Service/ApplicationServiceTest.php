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
use Meritoo\CommonBundle\Exception\Service\EmptyVersionFilePathException;
use Meritoo\CommonBundle\Exception\Service\UnreadableVersionFileException;
use Meritoo\CommonBundle\Service\ApplicationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the service who serves application
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(ApplicationService::class, OopVisibilityType::IS_PUBLIC, 1, 1);
    }

    public function testGetVersionUsingUnreadableVersionFilePath(): void
    {
        $this->expectException(UnreadableVersionFileException::class);
        $this->expectExceptionMessage('File nibh/purus/porta/malesuada/VERSION, who contains version of the application, is not readable. Does the file exist?');

        $service = new ApplicationService('nibh/purus/porta/malesuada/VERSION');
        $service->getVersion();
    }

    public function testGetVersionUsingEmptyVersionFilePath(): void
    {
        $this->expectException(EmptyVersionFilePathException::class);
        $this->expectExceptionMessage('Path of a file, who contains version of the application, is empty. Is there everything ok?');

        $service = new ApplicationService('');
        $service->getVersion();
    }

    public function testGetVersionUsingDependencyInjection(): void
    {
        $expected = new Version(1, 2, 0);

        $version = static::$container
            ->get(ApplicationService::class)
            ->getVersion();

        static::assertEquals($expected, $version);
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
