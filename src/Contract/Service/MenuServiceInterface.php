<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

use Meritoo\CommonBundle\Contract\Model\Menu\MenuItemInterface;

/**
 * Interface/Contract of the menu service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface MenuServiceInterface
{
    public function isActive(MenuItemInterface $menuItem): bool;
}
