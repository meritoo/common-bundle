<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\ValueObject;

/**
 * Interface/Contract of pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface PaginationInterface
{
    public function calculateOffset(): int;

    public function calculatePagesCount(): int;

    public function getCurrentPage(): int;

    public function getPerPage(): int;

    public function isValidPage(int $page): bool;
}
