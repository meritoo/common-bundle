<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Type\DependencyInjection;

use Meritoo\Common\Exception\Base\UnknownTypeException;
use Meritoo\CommonBundle\Type\DependencyInjection\ConfigurationFileType;

/**
 * An exception used while type of Dependency Injection (DI) configuration file is unknown
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class UnknownConfigurationFileTypeException extends UnknownTypeException
{
    /**
     * Creates exception
     *
     * @param string $unknownType Unknown type of Dependency Injection (DI) configuration file
     * @return UnknownConfigurationFileTypeException
     */
    public static function createException(string $unknownType): UnknownConfigurationFileTypeException
    {
        /** @var UnknownConfigurationFileTypeException $exception */
        $exception = static::create($unknownType, new ConfigurationFileType(), 'Dependency Injection (DI) configuration file');

        return $exception;
    }
}
