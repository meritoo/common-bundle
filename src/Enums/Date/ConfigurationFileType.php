<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Enums\Date;

use Meritoo\Common\Utilities\Miscellaneous;

enum ConfigurationFileType: string
{
    case PHP = 'php';
    case XML = 'xml';
    case YAML = 'yaml';

    /**
     * Returns type of configuration file based on name of the file
     *
     * @param string $fileName Name of configuration file
     *
     * @return ConfigurationFileType
     */
    public static function getTypeFromFileName(string $fileName): self
    {
        $fileExtension = strtolower(Miscellaneous::getFileExtension($fileName));

        return self::tryFrom($fileExtension);
    }
}
