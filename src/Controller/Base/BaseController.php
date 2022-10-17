<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Controller\Base;

use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Controller\BaseController\CannotRedirectToEmptyRefererUrlException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Base controller with common and useful methods
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
abstract class BaseController extends AbstractController
{
    /**
     * Serves request
     *
     * @var RequestServiceInterface
     */
    private RequestServiceInterface $requestService;

    /**
     * Class constructor
     *
     * @param RequestServiceInterface $requestService Serves request
     */
    public function __construct(RequestServiceInterface $requestService)
    {
        $this->requestService = $requestService;
    }

    protected function getRequestService(): RequestServiceInterface
    {
        return $this->requestService;
    }

    /**
     * Redirects to url of referer
     *
     * @return RedirectResponse
     * @throws CannotRedirectToEmptyRefererUrlException
     */
    protected function redirectToReferer(): RedirectResponse
    {
        $url = $this->requestService->fetchRefererUrl();

        // Oops, url of referer is unknown
        if ('' === $url) {
            throw CannotRedirectToEmptyRefererUrlException::create();
        }

        return $this->redirect($url);
    }

    /**
     * Redirects to url of referer or to given route, if url of referer is empty/unknown
     *
     * @param string $routeName       Name of route
     * @param array  $routeParameters (optional) Parameters of route
     * @return RedirectResponse
     */
    protected function redirectToRefererOrRoute(
        string $routeName,
        array $routeParameters = []
    ): RedirectResponse {
        try {
            return $this->redirectToReferer();
        } catch (CannotRedirectToEmptyRefererUrlException $exception) {
            return $this->redirectToRoute($routeName, $routeParameters);
        }
    }
}
