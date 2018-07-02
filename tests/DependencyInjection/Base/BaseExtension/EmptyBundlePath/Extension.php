<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\DependencyInjection\Base\BaseExtension\EmptyBundlePath;

use Meritoo\CommonBundle\DependencyInjection\Base\BaseExtension;

/**
 * Dependency Injection (DI) extension with empty path of directory where bundle exists
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Extension extends BaseExtension
{
    /**
     * {@inheritdoc}
     */
    protected function getBundleDirectoryPath(): string
    {
        return '';
    }
}
