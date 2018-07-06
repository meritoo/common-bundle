<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\Common\ValueObject\Version;
use Meritoo\CommonBundle\Application\Descriptor;
use Meritoo\CommonBundle\Exception\Service\EmptyVersionFilePathException;
use Meritoo\CommonBundle\Exception\Service\UnreadableVersionFileException;
use Meritoo\CommonBundle\Service\Base\BaseService;

/**
 * Serves application
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationService extends BaseService
{
    /**
     * Path of a file who contains version of the application
     *
     * @var string
     */
    private $versionFilePath;

    /**
     * Descriptor of application
     *
     * @var Descriptor
     */
    private $descriptor;

    /**
     * Class constructor
     *
     * @param string $versionFilePath        Path of a file who contains version of the application
     * @param string $applicationName        Name of application. May be displayed near logo.
     * @param string $applicationDescription Description of application. May be displayed near logo.
     */
    public function __construct(string $versionFilePath, string $applicationName, string $applicationDescription)
    {
        $this->versionFilePath = $versionFilePath;
        $this->createDescriptor($applicationName, $applicationDescription);
    }

    /**
     * Returns descriptor of application
     *
     * @return Descriptor
     */
    public function getDescriptor(): Descriptor
    {
        return $this->descriptor;
    }

    /**
     * Returns version of application
     *
     * @return Version
     */
    private function getVersion(): Version
    {
        /*
         * Oops, unknown/empty path of a file who contains version
         */
        if (empty($this->versionFilePath)) {
            throw EmptyVersionFilePathException::create();
        }

        /*
         * Oops, not readable/accessible file who contains version
         */
        if (!is_readable($this->versionFilePath)) {
            throw UnreadableVersionFileException::create($this->versionFilePath);
        }

        $contents = file_get_contents($this->versionFilePath);

        return Version::fromString($contents);
    }

    /**
     * Creates descriptor of application
     *
     * @param string $name        Name of application. May be displayed near logo.
     * @param string $description Description of application. May be displayed near logo.
     */
    private function createDescriptor(string $name, string $description): void
    {
        $version = $this->getVersion();
        $this->descriptor = new Descriptor($name, $description, $version);
    }
}
