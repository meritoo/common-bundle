<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Model\Menu;

/**
 * Interface/Contract of the item of menu
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface MenuItemInterface
{
    public function getName(): string;

    public function getRelatedRoutes(): ?array;

    public function getRoute(): ?string;

    public function getRouteParameters(): ?array;

    public function getUrl(): string;
}
