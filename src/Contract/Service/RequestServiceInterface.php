<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface/Contract of service that serves request
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface RequestServiceInterface
{
    public function fetchRefererUrl(): string;

    public function getCurrentRoute(): string;

    public function getCurrentRouteParameters(): array;

    /**
     * @param string $parameter
     * @return mixed
     */
    public function getParameter(string $parameter);

    public function getRefererUrl(Request $request): string;

    public function isCurrentRoute(string $route): bool;

    public function storeRefererUrl(string $url): self;

    public function storeRefererUrlFromRequest(Request $request): self;
}
