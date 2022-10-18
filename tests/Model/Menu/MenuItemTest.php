<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Model\Menu;

use Meritoo\CommonBundle\Model\Menu\MenuItem;
use PHPUnit\Framework\TestCase;

/**
 * Test case for an item of menu
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @covers    \Meritoo\CommonBundle\Model\Menu\MenuItem
 */
class MenuItemTest extends TestCase
{
    private MenuItem $menuItem;

    public function testGetName(): void
    {
        self::assertSame('Test me', $this->menuItem->getName());
    }

    public function testGetRelatedRoutes(): void
    {
        self::assertSame([], $this->menuItem->getRelatedRoutes());

        $relatedRoutes = ['test_route_1', 'test_route_2'];
        $menuItem = new MenuItem('Test me', '/test/me', null, [], $relatedRoutes);

        self::assertSame($relatedRoutes, $menuItem->getRelatedRoutes());
    }

    public function testGetRoute(): void
    {
        self::assertNull($this->menuItem->getRoute());

        $route = 'test_route';
        $menuItem = new MenuItem('Test me', '/test/me', $route);

        self::assertSame($route, $menuItem->getRoute());
    }

    public function testGetRouteParameters(): void
    {
        self::assertSame([], $this->menuItem->getRouteParameters());

        $routeParameters = ['test1' => 1, 'test2' => 2];
        $menuItem = new MenuItem('Test me', '/test/me', null, $routeParameters);

        self::assertSame($routeParameters, $menuItem->getRouteParameters());
    }

    public function testGetUrl(): void
    {
        self::assertSame('/test/me', $this->menuItem->getUrl());

    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuItem = new MenuItem('Test me', '/test/me');
    }
}
