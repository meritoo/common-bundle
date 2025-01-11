<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
use Meritoo\Common\Enums\OopVisibility;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Service\Request\UnknownRequestException;
use Meritoo\CommonBundle\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Test case for the service that serves request
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Service\RequestService
 * @covers    \Meritoo\CommonBundle\Exception\Service\Request\UnknownRequestException
 */
class RequestServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private RequestStack $requestStack;
    private RequestServiceInterface $requestService;

    public function provideCurrentRoute(): ?Generator
    {
        yield 'Unknown current route' => [
            '',
            'abc',
            false,
        ];

        yield 'Route different than current' => [
            'abc',
            'def',
            false,
        ];

        yield 'Route same as current' => [
            'abc',
            'abc',
            true,
        ];
    }

    /**
     * Provide request and url of referer
     *
     * @return Generator
     */
    public function provideRequestAndRefererUrl(): Generator
    {
        yield [
            new Request(),
            '',
        ];

        yield [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '',
            ]),
            '',
        ];

        yield [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/',
            ]),
            '/',
        ];

        yield [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/products/123',
            ]),
            '/products/123',
        ];
    }

    /**
     * Provide request and url of referer to store
     *
     * @return Generator
     */
    public function provideRequestAndRefererUrlToStore(): Generator
    {
        yield 'no referer data' => [
            new Request(),
            null,
        ];

        yield 'an empty string as referer' => [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '',
            ]),
            null,
        ];

        yield '"/" as referer' => [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/',
            ]),
            '/',
        ];

        yield '"/products/123" as referer' => [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/products/123',
            ]),
            '/products/123',
        ];
    }

    /**
     * Provide url to store/fetch
     *
     * @return Generator
     */
    public function provideUrl(): Generator
    {
        yield [''];
        yield ['/'];
        yield ['/products/123'];
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            RequestService::class,
            OopVisibility::Public,
            1,
            1,
        );
    }

    /**
     * @param string $expected Expected url of referer
     *
     * @dataProvider provideUrl
     * @runInSeparateProcess
     */
    public function testFetchRefererUrl(string $expected): void
    {
        $this
            ->requestStack
            ->getSession()
            ->set('meritoo_common.referer_url', $expected)
        ;

        static::assertSame($expected, $this->requestService->fetchRefererUrl());
        static::assertSame('', $this->requestService->fetchRefererUrl());
    }

    public function testGetCurrentRoute(): void
    {
        $expected = 'test-route';

        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with('_route')
            ->willReturn($expected)
        ;

        $service = new RequestService($requestStack);
        $result = $service->getCurrentRoute();

        static::assertSame($expected, $result);
    }

    public function testGetCurrentRouteIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);
        $this->expectExceptionMessage('Cannot get current request, because it is unknown');

        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($requestStack);
        $service->getCurrentRoute();
    }

    public function testGetCurrentRouteIfCurrentRouteIsUnknown(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with('_route')
            ->willReturn(null)
        ;

        $service = new RequestService($requestStack);
        $result = $service->getCurrentRoute();

        static::assertSame('', $result);
    }

    public function testGetCurrentRouteParameters(): void
    {
        $expected = [
            'parameter1' => 'test1',
            'parameter2' => 'test2',
        ];

        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with('_route_params')
            ->willReturn($expected)
        ;

        $service = new RequestService($requestStack);
        $result = $service->getCurrentRouteParameters();

        static::assertSame($expected, $result);
    }

    public function testGetCurrentRouteParametersIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);
        $this->expectExceptionMessage('Cannot get current request, because it is unknown');

        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($requestStack);
        $service->getCurrentRouteParameters();
    }

    public function testGetCurrentRouteParametersIfRouteParametersAreUnknown(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with('_route_params')
            ->willReturn(null)
        ;

        $service = new RequestService($requestStack);
        $result = $service->getCurrentRouteParameters();

        static::assertSame([], $result);
    }

    public function testGetParameter(): void
    {
        $expected = 'test-value';
        $parameter = 'test-parameter';

        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with($parameter)
            ->willReturn($expected)
        ;

        $service = new RequestService($requestStack);
        $result = $service->getParameter('test-parameter');

        static::assertSame($expected, $result);
    }

    public function testGetParameterIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);
        $this->expectExceptionMessage('Cannot get current request, because it is unknown');

        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($requestStack);
        $service->getParameter('test');
    }

    /**
     * @param Request $request The request (that probably contains referer)
     * @param null|string $expected Expected url of referer
     *
     * @dataProvider provideRequestAndRefererUrl
     */
    public function testGetRefererUrl(Request $request, ?string $expected): void
    {
        static::assertSame($expected, $this->requestService->getRefererUrl($request));
    }

    /**
     * @dataProvider provideCurrentRoute
     */
    public function testIsCurrentRoute(string $currentRoute, string $route, bool $expected): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $request = $this->createMock(Request::class);

        $requestStack
            ->expects(self::once())
            ->method('getCurrentRequest')
            ->willReturn($request)
        ;

        $request
            ->expects(self::once())
            ->method('get')
            ->with('_route')
            ->willReturn($currentRoute)
        ;

        $service = new RequestService($requestStack);
        self::assertSame($expected, $service->isCurrentRoute($route));
    }

    public function testIsCurrentRouteIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);
        $this->expectExceptionMessage('Cannot get current request, because it is unknown');

        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($requestStack);
        $service->isCurrentRoute('');
    }

    /**
     * @param string $url The referer url to store
     *
     * @dataProvider provideUrl
     * @runInSeparateProcess
     */
    public function testStoreRefererUrl(string $url): void
    {
        $this->requestService->storeRefererUrl($url);

        $refererUrl = $this
            ->requestStack
            ->getSession()
            ->get('meritoo_common.referer_url')
        ;

        static::assertSame($url, $refererUrl);
    }

    /**
     * @param Request $request The request (that probably contains referer)
     * @param null|string $expected Expected url of referer
     *
     * @dataProvider provideRequestAndRefererUrlToStore
     * @runInSeparateProcess
     */
    public function testStoreRefererUrlFromRequest(Request $request, ?string $expected): void
    {
        static::getContainer()
            ->get(RequestServiceInterface::class)
            ->storeRefererUrlFromRequest($request)
        ;

        $refererUrl = $this
            ->requestStack
            ->getSession()
            ->get('meritoo_common.referer_url')
        ;

        static::assertSame($expected, $refererUrl);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var RequestStack $requestStack */
        $requestStack = static::getContainer()->get(RequestStack::class);

        /** @var RequestServiceInterface $requestService */
        $requestService = static::getContainer()->get(RequestServiceInterface::class);

        $request = $this->createRequestWithSession();
        $requestStack->push($request);

        $this->requestStack = $requestStack;
        $this->requestService = $requestService;
    }

    private function createRequestWithSession(): Request
    {
        $session = new Session();

        $request = new Request();
        $request->setSession($session);

        return $request;
    }
}
