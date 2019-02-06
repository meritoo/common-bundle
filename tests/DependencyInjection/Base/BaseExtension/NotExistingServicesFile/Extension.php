<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\NotExistingServicesFile;

use Meritoo\Common\Utilities\Miscellaneous;
use Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension;

/**
 * Dependency Injection (DI) extension with not existing services configuration file
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
    protected function getBundleDirectoryPath(): string
    {
        return Miscellaneous::concatenatePaths(__DIR__, '..');
    }

    /**
     * {@inheritdoc}
     */
    protected function getServicesFileName(): string
    {
        return 'purus_dolor.jpg';
    }
}
