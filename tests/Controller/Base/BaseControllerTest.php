<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Controller\Base;

use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Controller\BaseController\CannotRedirectToEmptyRefererUrlException;
use Meritoo\Test\CommonBundle\Controller\Base\BaseController\RealController;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test case for the base controller with common and useful methods
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Controller\Base\BaseController
 */
class BaseControllerTest extends KernelTestCase
{
    private RequestServiceInterface $requestService;

    public function testRedirectToReferer(): void
    {
        $refererUrl = '/';
        $this->requestService->storeRefererUrl($refererUrl);

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

    public function testRedirectToRefererUsingEmptyRefererUrl(): void
    {
        $this->expectException(CannotRedirectToEmptyRefererUrlException::class);

        $controller = $this->getRealController();
        $controller->read();
    }

    public function testSimpleAction(): void
    {
        $controller = $this->getRealController();
        $response = $controller->index();

        static::assertSame(200, $response->getStatusCode());
        static::assertSame('<p>Lorem ipsum</p>', $response->getContent());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var RequestServiceInterface $requestService */
        $requestService = static::getContainer()->get(RequestServiceInterface::class);

        $this->requestService = $requestService;
    }

    /**
     * Returns instance of RealController used for testing
     *
     * @return RealController
     */
    private function getRealController(): RealController
    {
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
        $controller = new RealController($this->requestService);
        $controller->setContainer(static::getContainer());

        return $controller;
    }
}
