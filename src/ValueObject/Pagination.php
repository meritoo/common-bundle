<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\ValueObject;

use Meritoo\CommonBundle\Contract\ValueObject\PaginationInterface;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectCurrentPageException;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectPerPageException;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectTotalAmountException;

/**
 * Represents core parameters used to serve pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class Pagination implements PaginationInterface
{
    /** @var int */
    private $totalAmount;

    /** @var int */
    private $perPage;

    /** @var int */
    private $currentPage;

    public function __construct(int $totalAmount, int $perPage, int $currentPage = 1)
    {
        $this->validate($totalAmount, $perPage, $currentPage);

        $this->totalAmount = $totalAmount;
        $this->perPage = $perPage;
        $this->currentPage = $currentPage;
    }

    public function calculateOffset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }

    public function calculatePagesCount(): int
    {
        return (int) ceil($this->totalAmount / $this->perPage);
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function isValidPage(int $page): bool
    {
        $pagesCount = $this->calculatePagesCount();

        // If there is no data, 1st page is allowed/valid only
        if ($pagesCount === 0) {
            return $page === 1;
        }

        return $page > 0 && $page <= $pagesCount;
    }

    private function validate(int $totalAmount, int $perPage, int $currentPage): void
    {
        if ($totalAmount < 0) {
            throw new IncorrectTotalAmountException($totalAmount);
        }

        if ($perPage <= 0) {
            throw new IncorrectPerPageException($perPage);
        }

        if ($currentPage <= 0) {
            throw new IncorrectCurrentPageException($currentPage);
        }
    }
}
