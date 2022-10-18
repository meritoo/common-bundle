<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Contract\Model\Menu\MenuItemInterface;
use Meritoo\CommonBundle\Contract\Service\MenuServiceInterface;
use Meritoo\CommonBundle\Service\Base\BaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Service for menu
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class MenuService extends BaseService implements MenuServiceInterface
{
    private RequestStack $requestStack;
    private ?string $currentRoute = null;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function isActive(MenuItemInterface $menuItem): bool
    {
        /*
         * TODO Rebuild this method by implementing Chain Of Responsibilities or any other design pattern
         *
         * More:
         * https://designpatternsphp.readthedocs.io/en/latest/Behavioral/ChainOfResponsibilities/README.html
         * https://refactoring.guru/design-patterns/chain-of-responsibility
         */

        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            return false;
        }

        if ($this->isItCurrentUrl($menuItem, $request)) {
            return true;
        }

        if ($this->isItCurrentRoute($menuItem, $request)) {
            return true;
        }

        if ($this->isItRelatedRoute($menuItem, $request)) {
            return true;
        }

        return false;
    }

    private function getCurrentRoute(Request $request): string
    {
        if ($this->currentRoute === null) {
            $this->currentRoute = $request->get('_route');
        }

        return $this->currentRoute;
    }

    private function isItCurrentRoute(MenuItemInterface $menuItem, Request $request): bool
    {
        $currentRoute = $this->getCurrentRoute($request);
        $currentRouteParameters = $request->get('_route_params');

        return $menuItem->getRoute() === $currentRoute && $menuItem->getRouteParameters() === $currentRouteParameters;
    }

    private function isItCurrentUrl(MenuItemInterface $menuItem, Request $request): bool
    {
        $currentUrl = $request->getRequestUri();

        return $currentUrl === $menuItem->getUrl();
    }

    private function isItRelatedRoute(MenuItemInterface $menuItem, Request $request): bool
    {
        $relatedRoutes = $menuItem->getRelatedRoutes();

        if (empty($relatedRoutes)) {
            return false;
        }

        $currentRoute = $this->getCurrentRoute($request);

        foreach ($relatedRoutes as $relatedRoute) {
            if ($relatedRoute === $currentRoute) {
                return true;
            }
        }

        return false;
    }
}
