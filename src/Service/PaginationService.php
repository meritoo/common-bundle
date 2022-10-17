<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Contract\Service\PaginationServiceInterface;
use Meritoo\CommonBundle\Exception\Pagination\MissingPerPageAmountException;
use Meritoo\CommonBundle\Exception\Pagination\MissingRouteNameException;
use Meritoo\CommonBundle\Exception\Pagination\MissingTemplatePathException;
use Meritoo\CommonBundle\Exception\Pagination\MissingTotalAmountException;
use Meritoo\CommonBundle\ValueObject\Pagination;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

/**
 * Serves pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class PaginationService implements PaginationServiceInterface
{
    private const PAGE_NUMBER_ROUTE_PARAMETER = 'page';
    private const DEFAULT_NEARBY_CURRENT_PAGE_COUNT = 2;

    private Environment $twig;
    private RouterInterface $router;
    private ?Pagination $pagination = null;
    private string $templatePath;
    private string $route = '';
    private array $routeParameters;
    private ?int $perPage;
    private ?int $nearbyCurrentPageCount;
    private ?int $totalAmount = null;

    public function __construct(
        Environment $twig,
        RouterInterface $router,
        string $templatePath = '',
        ?int $perPage = null,
        ?int $nearbyCurrentPageCount = null
    ) {
        $this->twig = $twig;
        $this->router = $router;
        $this->templatePath = $templatePath;
        $this->perPage = $perPage;
        $this->nearbyCurrentPageCount = $nearbyCurrentPageCount;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function setPerPage(int $perPage): void
    {
        $this->perPage = $perPage;
    }

    public function isValidPage(int $page): bool
    {
        return $this->getPagination()->isValidPage($page);
    }

    public function renderPagination(int $currentPage = 1): string
    {
        if (!$this->isAvailable($currentPage)) {
            return '';
        }

        $this->verifyRenderRequirements();

        $pagesCount = $this->getPagination()->calculatePagesCount();
        $urls = $this->createUrls($pagesCount, $currentPage);

        $previousUrl = $this->getPreviousUrl($urls, $currentPage);
        $nextUrl = $this->getNextUrl($urls, $currentPage);

        return $this
            ->twig
            ->render(
                $this->templatePath,
                [
                    'urls' => $urls,
                    'current_page' => $currentPage,
                    'pages_count' => $pagesCount,
                    'previous_url' => $previousUrl,
                    'next_url' => $nextUrl,
                ]
            )
        ;
    }

    public function setNearbyCurrentPageCount(int $count): void
    {
        $this->nearbyCurrentPageCount = $count;
    }

    public function setRoute(string $route, array $parameters = []): void
    {
        $this->route = $route;
        $this->routeParameters = $parameters;
    }

    public function setTemplatePath(string $path): void
    {
        $this->templatePath = $path;
    }

    public function setTotalAmount(int $amount): void
    {
        $this->totalAmount = $amount;
    }

    private function createUrls(int $pagesCount, int $currentPage): array
    {
        $urls = [];

        for ($pageNo = 1; $pageNo <= $pagesCount; $pageNo++) {
            if (!$this->shouldGenerateUrl($pageNo, $currentPage, $pagesCount)) {
                continue;
            }

            $this->routeParameters[self::PAGE_NUMBER_ROUTE_PARAMETER] = $pageNo;
            $urls[$pageNo] = $this->router->generate($this->route, $this->routeParameters);
        }

        unset($this->routeParameters[self::PAGE_NUMBER_ROUTE_PARAMETER]);

        return $urls;
    }

    private function getNearbyCurrentPageCount(): int
    {
        return $this->nearbyCurrentPageCount ?? self::DEFAULT_NEARBY_CURRENT_PAGE_COUNT;
    }

    private function getNextUrl(array $urls, int $currentPage): string
    {
        $nextPage = $currentPage + 1;

        return $urls[$nextPage] ?? '';
    }

    private function getPagination(): Pagination
    {
        $this->verifyBasicRequirements();

        if ($this->pagination === null) {
            $this->pagination = new Pagination($this->totalAmount, $this->perPage);
        }

        return $this->pagination;
    }

    private function getPreviousUrl(array $urls, int $currentPage): string
    {
        $previousPage = $currentPage - 1;

        return $urls[$previousPage] ?? '';
    }

    private function isAvailable(int $currentPage): bool
    {
        $moreThanOnePage = $this->totalAmount > $this->perPage;
        $isCurrentPageValid = $this->isValidPage($currentPage);

        return $moreThanOnePage && $isCurrentPageValid;
    }

    private function shouldGenerateUrl(int $page, int $currentPage, int $pagesCount): bool
    {
        $nearbyPagesCount = $this->getNearbyCurrentPageCount();

        $neighborLeft = $currentPage - $nearbyPagesCount;
        $neighborRight = $currentPage + $nearbyPagesCount;

        return $page === 1
            || $page === $pagesCount
            || ($page >= $neighborLeft && $page <= $neighborRight);
    }

    private function verifyBasicRequirements(): void
    {
        if ($this->perPage === null) {
            throw MissingPerPageAmountException::create();
        }

        if ($this->totalAmount === null) {
            throw MissingTotalAmountException::create();
        }
    }

    private function verifyRenderRequirements(): void
    {
        if (empty($this->templatePath)) {
            throw MissingTemplatePathException::create();
        }

        if (empty($this->route)) {
            throw MissingRouteNameException::create();
        }
    }
}
