<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestServiceInterface
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface RequestServiceInterface
{
    public function getRefererUrl(Request $request): string;

    public function storeRefererUrl(string $url): self;

    public function storeRefererUrlFromRequest(Request $request): self;

    public function fetchRefererUrl(): string;

    public function getCurrentRoute(): string;

    public function getCurrentRouteParameters(): array;

    /**
     * @param string $parameter
     * @return mixed
     */
    public function getParameter(string $parameter);

    public function isCurrentRoute(string $route): bool;
}
