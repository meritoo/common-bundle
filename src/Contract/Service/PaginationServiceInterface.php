<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

/**
 * Interface/Contract of service that serves pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface PaginationServiceInterface
{
    public function getPerPage(): ?int;

    public function isValidPage(int $page): bool;

    public function renderPagination(int $currentPage = 1): string;

    public function setNearbyCurrentPageCount(int $count): void;

    public function setPerPage(int $perPage): void;

    public function setRoute(string $route, array $parameters = []): void;

    public function setTemplatePath(string $path): void;

    public function setTotalAmount(int $amount): void;
}
