<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Type\DependencyInjection;

use Meritoo\Common\Type\Base\BaseType;
use Meritoo\Common\Utilities\Miscellaneous;
use Meritoo\CommonBundle\Exception\Type\DependencyInjection\UnknownConfigurationFileTypeException;

/**
 * Type of Dependency Injection (DI) configuration file
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ConfigurationFileType extends BaseType
{
    /**
     * The PHP configuration file
     *
     * @var string
     */
    public const PHP = 'php';

    /**
     * The XML configuration file
     *
     * @var string
     */
    public const XML = 'xml';

    /**
     * The YAML configuration file
     *
     * @var string
     */
    public const YAML = 'yaml';

    /**
     * Returns type of configuration file based on name of the file
     *
     * @param string $fileName Name of configuration file
     * @throws UnknownConfigurationFileTypeException
     * @return string
     */
    public static function getTypeFromFileName(string $fileName): string
    {
        $fileExtension = strtolower(Miscellaneous::getFileExtension($fileName));

        /*
         * Oops, incorrect type/extension of configuration file
         */
        if (false === (new static())->isCorrectType($fileExtension)) {
            throw UnknownConfigurationFileTypeException::createException($fileExtension);
        }

        return $fileExtension;
    }
}
