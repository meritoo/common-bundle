<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Model\Menu;

use Meritoo\CommonBundle\Contract\Model\Menu\MenuItemInterface;

/**
 * An item of menu
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class MenuItem implements MenuItemInterface
{
    private string $name;
    private string $url;
    private ?string $route;
    private array $routeParameters;
    private array $relatedRoutes;

    public function __construct(
        string $name,
        string $url,
        string $route = null,
        array $routeParameters = [],
        array $relatedRoutes = []
    ) {
        $this->name = $name;
        $this->url = $url;
        $this->route = $route;
        $this->routeParameters = $routeParameters;
        $this->relatedRoutes = $relatedRoutes;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRelatedRoutes(): array
    {
        return $this->relatedRoutes;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
