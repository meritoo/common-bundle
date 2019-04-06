<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Service\RequestService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            RequestService::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
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
            ->get(RequestService::class)
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
            ->get(RequestService::class)
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
            ->get(RequestService::class)
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
            ->get(RequestService::class)
            ->fetchRefererUrl()
        ;

        static::assertSame($expected, $url);

        $urlAgain = static::$container
            ->get(RequestService::class)
            ->fetchRefererUrl()
        ;

        static::assertSame('', $urlAgain);
    }

    /**
     * Provide url to store/fetch
     *
     * @return \Generator
     */
    public function provideUrl(): \Generator
    {
        yield[''];
        yield['/'];
        yield['/products/123'];
    }

    /**
     * Provide request and url of referer
     *
     * @return \Generator
     */
    public function provideRequestAndRefererUrl(): \Generator
    {
        yield[
            new Request(),
            '',
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '',
            ]),
            '',
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/',
            ]),
            '/',
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/products/123',
            ]),
            '/products/123',
        ];
    }

    /**
     * Provide request and url of referer to store
     *
     * @return \Generator
     */
    public function provideRequestAndRefererUrlToStore(): \Generator
    {
        yield[
            new Request(),
            null,
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '',
            ]),
            null,
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/',
            ]),
            '/',
        ];

        yield[
            new Request([], [], [], [], [], [
                'HTTP_REFERER' => '/products/123',
            ]),
            '/products/123',
        ];
    }
}
