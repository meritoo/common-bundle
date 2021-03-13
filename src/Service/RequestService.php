<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Service\Request\UnknownRequestException;
use Meritoo\CommonBundle\Service\Base\BaseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Serves request
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class RequestService extends BaseService implements RequestServiceInterface
{
    private const ROUTE_PARAMETER = '_route';
    private const PARAMETERS_PARAMETER = '_route_params';

    /**
     * The session
     *
     * @var
     */
    private $session;

    /**
     * Request stack
     *
     * @var RequestStack
     */
    private $requestStack;

    /**
     * Key used to store the referer url
     *
     * @var string
     */
    private $refererUrlKey = 'meritoo_common.referer_url';

    /**
     * Class constructor
     *
     * @param SessionInterface $session The session
     * @param RequestStack     $requestStack
     */
    public function __construct(SessionInterface $session, RequestStack $requestStack)
    {
        $this->session = $session;
        $this->requestStack = $requestStack;
    }

    /**
     * Returns url of referer
     *
     * @param Request $request The request (that probably contains referer)
     * @return string
     */
    public function getRefererUrl(Request $request): string
    {
        return $request->headers->get('referer', '');
    }

    /**
     * Stores url of referer in session
     *
     * @param string $url Url of referer to store
     * @return RequestServiceInterface
     */
    public function storeRefererUrl(string $url): RequestServiceInterface
    {
        $this->session->set($this->refererUrlKey, $url);

        return $this;
    }

    /**
     * Stores the referer url in session grabbed from given request
     *
     * @param Request $request The request (that probably contains referer)
     * @return RequestServiceInterface
     */
    public function storeRefererUrlFromRequest(Request $request): RequestServiceInterface
    {
        $url = $this->getRefererUrl($request);

        /*
         * No referer?
         * Nothing to do
         */
        if ('' === $url) {
            return $this;
        }

        return $this->storeRefererUrl($url);
    }

    /**
     * Fetches url of referer and removes it from session
     *
     * @return string
     */
    public function fetchRefererUrl(): string
    {
        $url = $this->session->get($this->refererUrlKey, '');
        $this->session->remove($this->refererUrlKey);

        return $url;
    }

    public function getCurrentRoute(): string
    {
        return $this->getParameter(self::ROUTE_PARAMETER);
    }

    public function getCurrentRouteParameters(): array
    {
        return $this->getParameter(self::PARAMETERS_PARAMETER);
    }

    public function getParameter(string $parameter)
    {
        return $this->getCurrentRequest()->get($parameter);
    }

    private function getCurrentRequest(): Request
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($request === null) {
            throw new UnknownRequestException();
        }

        return $request;
    }
}
