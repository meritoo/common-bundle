<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\Service;

/**
 * Interface/Contract of the carousel's service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface CarouselServiceInterface
{
    public function calculateCurrentOffset(bool $moveForward): ?int;

    public function goBackward(): array;

    public function goForward(): array;

    public function setPreviousOffset(int $offset): void;

    public function setVisibleCount(int $count): void;
}
