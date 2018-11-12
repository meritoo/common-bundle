<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Serves request
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class RequestService
{
    /**
     * The session
     *
     * @var SessionInterface
     */
    private $session;

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
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
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
     * @return RequestService
     */
    public function storeRefererUrl(string $url): RequestService
    {
        $this->session->set($this->refererUrlKey, $url);

        return $this;
    }

    /**
     * Stores the referer url in session grabbed from given request
     *
     * @param Request $request The request (that probably contains referer)
     * @return RequestService
     */
    public function storeRefererUrlFromRequest(Request $request): RequestService
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
}
