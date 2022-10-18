<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Meritoo\CommonBundle\Contract\Service\MenuServiceInterface;
use Meritoo\CommonBundle\Model\Menu\MenuItem;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Runtime class related to MenuExtension Twig Extension.
 * Required to create lazy-loaded Twig Extension.
 *
 * @author    Krzysztof Nizioł <krzysztof.niziol@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 */
final class MenuRuntime implements RuntimeExtensionInterface
{
    private MenuServiceInterface $menuService;

    public function __construct(MenuServiceInterface $menuService)
    {
        $this->menuService = $menuService;
    }

    public function isActive(
        string $itemUrl,
        string $itemRoute,
        ?array $itemRouteParameters = [],
        ?array $itemRelatedRoutes = []
    ): bool {
        $menuItem = new MenuItem('', $itemUrl, $itemRoute, $itemRouteParameters, $itemRelatedRoutes);

        return $this->menuService->isActive($menuItem);
    }
}
