<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Controller\Base;

use Meritoo\CommonBundle\Exception\Controller\BaseController\CannotRedirectToEmptyRefererUrlException;
use Meritoo\CommonBundle\Service\RequestService;
use Meritoo\Test\CommonBundle\Controller\Base\BaseController\RealController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the base controller with common and useful methods
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Controller\Base\BaseController
 */
class BaseControllerTest extends KernelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
    }

    public function testSimpleAction(): void
    {
        $controller = $this->getRealController();
        $response = $controller->index();

        static::assertSame(200, $response->getStatusCode());
        static::assertSame('<p>Cras Vestibulum</p>', $response->getContent());
    }

    public function testRedirectToRefererUsingEmptyRefererUrl(): void
    {
        $this->expectException(CannotRedirectToEmptyRefererUrlException::class);

        $controller = $this->getRealController();
        $controller->read();
    }

    public function testRedirectToReferer(): void
    {
        /** @var RequestService $requestService */
        $requestService = static::$container->get(RequestService::class);

        $refererUrl = '/';
        $requestService->storeRefererUrl($refererUrl);

        $controller = $this->getRealController();
        $response = $controller->read();

        static::assertSame(302, $response->getStatusCode());
        static::assertSame($refererUrl, $response->getTargetUrl());
    }

    public function testRedirectToRefererOrRoute(): void
    {
        $controller = $this->getRealController();
        $response = $controller->create();

        static::assertSame(302, $response->getStatusCode());
        static::assertSame('/test/index', $response->getTargetUrl());
    }

    /**
     * Returns instance of RealController used for testing
     *
     * @return RealController
     */
    private function getRealController(): RealController
    {
        /** @var RequestService $requestService */
        $requestService = static::$container->get(RequestService::class);

        /*
         * I have to pass container to the controller to avoid exception:
         * Call to a member function get() on null
         *
         * in method:
         * \Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait::generateUrl()
         *
         * caused by call of "get()" method:
         * $this->container->get()
         */
        $controller = new RealController($requestService);
        $controller->setContainer(static::$container);

        return $controller;
    }
}
