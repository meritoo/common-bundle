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
use Meritoo\CommonBundle\Service\ResponseService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Test case for the service that serves response
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Service\ResponseService
 */
class ResponseServiceTest extends KernelTestCase
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
            ResponseService::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    /**
     * @param string           $routeName       The name of the route. Used to build url used for redirection.
     * @param array            $routeParameters An array of parameters. Used to build url used for redirection.
     * @param string           $url             Url that should be generated and used for redirection
     * @param RedirectResponse $expected        Expected instance of RedirectResponse
     *
     * @dataProvider provideRouteDetailsForRedirectResponse
     */
    public function testGetRedirectResponse(
        string $routeName,
        array $routeParameters,
        string $url,
        RedirectResponse $expected
    ): void {
        $redirectResponse = $this
            ->getResponseService($routeName, $routeParameters, $url)
            ->getRedirectResponse($routeName, $routeParameters)
        ;

        static::assertSame($expected->getTargetUrl(), $redirectResponse->getTargetUrl());
        static::assertSame($expected->getContent(), $redirectResponse->getContent());
        static::assertSame($expected->getProtocolVersion(), $redirectResponse->getProtocolVersion());
        static::assertSame($expected->getStatusCode(), $redirectResponse->getStatusCode());
        static::assertSame($expected->getCharset(), $redirectResponse->getCharset());
    }

    /**
     * Provide route details to build/create the "redirect response"
     *
     * @return \Generator
     */
    public function provideRouteDetailsForRedirectResponse(): \Generator
    {
        yield[
            'test',
            [],
            '/test',
            new RedirectResponse('/test'),
        ];

        yield[
            'products_list',
            [
                'page'     => 1,
                'order-by' => 'name',
            ],
            '/products/1/sort/name',
            new RedirectResponse('/products/1/sort/name'),
        ];
    }

    /**
     * Returns instance of ResponseService with all related and mocked instances
     *
     * @param string $routeName       The name of the route. Used to build url used for redirection.
     * @param array  $routeParameters An array of parameters. Used to build url used for redirection.
     * @param string $url             Url that should be generated and used for redirection
     * @return ResponseService
     */
    private function getResponseService(string $routeName, array $routeParameters, string $url): ResponseService
    {
        $router = $this->createMock(RouterInterface::class);

        $router
            ->expects(static::once())
            ->method('generate')
            ->with($routeName, $routeParameters)
            ->willReturn($url)
        ;

        return new ResponseService($router);
    }
}
