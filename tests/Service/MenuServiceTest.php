<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Meritoo\CommonBundle\Model\Menu\MenuItem;
use Meritoo\CommonBundle\Service\MenuService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @internal
 * @covers \Meritoo\CommonBundle\Service\MenuService
 */
class MenuServiceTest extends TestCase
{
    private MenuService $menuService;

    /** @var MockObject|RequestStack */
    private $requestStack;

    public function testIsActiveIfCurrentRequestIsUnknown(): void
    {
        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn(null)
        ;

        $menuItem = new MenuItem('My Item', '/my-url');
        self::assertFalse($this->menuService->isActive($menuItem));
    }

    public function testIsActiveIfCurrentRouteAndParametersAreSameAsItemRoute(): void
    {
        $request = $this->createMock(Request::class);

        $route = 'my_route';
        $routeParameters = ['parameter1' => 'value1'];

        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive(
                ['_route'],
                ['_route_params']
            )
            ->willReturnOnConsecutiveCalls(
                $route,
                $routeParameters
            )
        ;

        $menuItem = new MenuItem('My Item', '/my-url', $route, $routeParameters);
        self::assertTrue($this->menuService->isActive($menuItem));
    }

    public function testIsActiveIfCurrentRouteIsNotRelatedRoute(): void
    {
        $request = $this->createMock(Request::class);

        $route = 'related_route_3';
        $routeParameters = [];

        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive(
                ['_route'],
                ['_route_params']
            )
            ->willReturnOnConsecutiveCalls(
                $route,
                $routeParameters
            )
        ;

        $relatedRoutes = [
            'related_route_1',
            'related_route_2',
        ];

        $menuItem = new MenuItem('My Item', '/my-url', null, [], $relatedRoutes);
        self::assertFalse($this->menuService->isActive($menuItem));
    }

    public function testIsActiveIfCurrentRouteIsRelatedRoute(): void
    {
        $request = $this->createMock(Request::class);

        $route = 'related_route_1';
        $routeParameters = [];

        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive(
                ['_route'],
                ['_route_params']
            )
            ->willReturnOnConsecutiveCalls(
                $route,
                $routeParameters
            )
        ;

        $relatedRoutes = [
            'related_route_1',
            'related_route_2',
        ];

        $menuItem = new MenuItem('My Item', '/my-url', null, [], $relatedRoutes);
        self::assertTrue($this->menuService->isActive($menuItem));
    }

    public function testIsActiveIfCurrentRouteIsSameButParametersAreDifferentThanItem(): void
    {
        $request = $this->createMock(Request::class);

        $route = 'my_route';
        $routeParameters = ['parameter1' => 'value1'];
        $itemRouteParameters = ['parameter1' => 'value123'];

        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::exactly(2))
            ->method('get')
            ->withConsecutive(
                ['_route'],
                ['_route_params']
            )
            ->willReturnOnConsecutiveCalls(
                $route,
                $routeParameters
            )
        ;

        $menuItem = new MenuItem('My Item', '/my-url', $route, $itemRouteParameters);
        self::assertFalse($this->menuService->isActive($menuItem));
    }

    public function testIsActiveIfCurrentUrlIsSameAsItemUrl(): void
    {
        $request = $this->createMock(Request::class);
        $url = '/my-url';

        $this
            ->requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('getRequestUri')
            ->willReturn($url)
        ;

        $menuItem = new MenuItem('My Item', $url);
        self::assertTrue($this->menuService->isActive($menuItem));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->requestStack = $this->createMock(RequestStack::class);
        $this->menuService = new MenuService($this->requestStack);
    }
}
