<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\Common\ValueObject\Version;
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
     * Class constructor
     *
     * @param string $versionFilePath Path of a file who contains version of the application
     */
    public function __construct(string $versionFilePath)
    {
        $this->versionFilePath = $versionFilePath;
    }

    /**
     * Returns version of application
     *
     * @return Version
     */
    public function getVersion(): Version
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
}
