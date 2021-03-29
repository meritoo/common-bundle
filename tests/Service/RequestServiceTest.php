<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Service\Request\UnknownRequestException;
use Meritoo\CommonBundle\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Test case for the service that serves request
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Service\RequestService
 */
class RequestServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            RequestService::class,
            OopVisibilityType::IS_PUBLIC,
            2,
            2
        );
    }

    /**
     * @param Request     $request  The request (that probably contains referer)
     * @param null|string $expected Expected url of referer
     *
     * @dataProvider provideRequestAndRefererUrl
     */
    public function testGetRefererUrl(Request $request, ?string $expected): void
    {
        $url = static::$container
            ->get(RequestServiceInterface::class)
            ->getRefererUrl($request)
        ;

        static::assertSame($expected, $url);
    }

    /**
     * @param string $url The referer url to store
     * @dataProvider provideUrl
     */
    public function testStoreRefererUrl(string $url): void
    {
        static::$container
            ->get(RequestServiceInterface::class)
            ->storeRefererUrl($url)
        ;

        $stored = static::$container
            ->get(SessionInterface::class)
            ->get('meritoo_common.referer_url')
        ;

        static::assertSame($url, $stored);
    }

    /**
     * @param Request     $request  The request (that probably contains referer)
     * @param null|string $expected Expected url of referer
     *
     * @dataProvider provideRequestAndRefererUrlToStore
     */
    public function testStoreRefererUrlFromRequest(Request $request, ?string $expected): void
    {
        static::$container
            ->get(RequestServiceInterface::class)
            ->storeRefererUrlFromRequest($request)
        ;

        $stored = static::$container
            ->get(SessionInterface::class)
            ->get('meritoo_common.referer_url')
        ;

        static::assertSame($expected, $stored);
    }

    /**
     * @param string $expected Expected url of referer
     * @dataProvider provideUrl
     */
    public function testFetchRefererUrl(string $expected): void
    {
        static::$container
            ->get(SessionInterface::class)
            ->set('meritoo_common.referer_url', $expected)
        ;

        $url = static::$container
            ->get(RequestServiceInterface::class)
            ->fetchRefererUrl()
        ;

        static::assertSame($expected, $url);

        $urlAgain = static::$container
            ->get(RequestServiceInterface::class)
            ->fetchRefererUrl()
        ;

        static::assertSame('', $urlAgain);
    }

    public function testGetParameterIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);

        $session = $this->createMock(SessionInterface::class);
        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($session, $requestStack);
        $service->getParameter('test');
    }

    public function testGetParameter(): void
    {
        $expected = 'test-value';
        $parameter = 'test-parameter';

        $session = $this->createMock(SessionInterface::class);
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

        $service = new RequestService($session, $requestStack);
        $result = $service->getParameter('test-parameter');

        static::assertSame($expected, $result);
    }

    public function testGetCurrentRouteIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);

        $session = $this->createMock(SessionInterface::class);
        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($session, $requestStack);
        $service->getCurrentRoute();
    }

    public function testGetCurrentRouteIfCurrentRouteIsUnknown(): void
    {
        $session = $this->createMock(SessionInterface::class);
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

        $service = new RequestService($session, $requestStack);
        $result = $service->getCurrentRoute();

        static::assertSame('', $result);
    }

    public function testGetCurrentRoute(): void
    {
        $expected = 'test-route';

        $session = $this->createMock(SessionInterface::class);
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

        $service = new RequestService($session, $requestStack);
        $result = $service->getCurrentRoute();

        static::assertSame($expected, $result);
    }

    public function testGetCurrentRouteParametersIfCurrentRequestIsUnknown(): void
    {
        $this->expectException(UnknownRequestException::class);

        $session = $this->createMock(SessionInterface::class);
        $requestStack = $this->createMock(RequestStack::class);

        $service = new RequestService($session, $requestStack);
        $service->getCurrentRouteParameters();
    }

    public function testGetCurrentRouteParametersIfRouteParametersAreUnknown(): void
    {
        $session = $this->createMock(SessionInterface::class);
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

        $service = new RequestService($session, $requestStack);
        $result = $service->getCurrentRouteParameters();

        static::assertSame([], $result);
    }

    public function testGetCurrentRouteParameters(): void
    {
        $expected = [
            'parameter1' => 'test1',
            'parameter2' => 'test2',
        ];

        $session = $this->createMock(SessionInterface::class);
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

        $service = new RequestService($session, $requestStack);
        $result = $service->getCurrentRouteParameters();

        static::assertSame($expected, $result);
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
        yield [
            new Request(),
            null,
        ];

        yield [
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '',
            ]),
            null,
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
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }
}
