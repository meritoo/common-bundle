<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\PhpServicesFileType;

use Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension;

/**
 * Dependency Injection (DI) extension with PHP services configuration file type
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @coversNothing
 */
class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    protected const CONFIGURATION_PATH = '';

    /**
     * {@inheritdoc}
     */
    protected function getBundleDirectoryPath(): string
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    protected function getServicesFileName(): string
    {
        return 'services.php';
    }
}
