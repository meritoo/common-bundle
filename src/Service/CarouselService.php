<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Service;

use Meritoo\CommonBundle\Contract\DataProvider\Carousel\CarouselDataProviderInterface;
use Meritoo\CommonBundle\Contract\Service\CarouselServiceInterface;
use Meritoo\CommonBundle\Exception\Carousel\VisibleCountNeedsToBeGreaterThanZeroException;

/**
 * Serves carousel
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class CarouselService implements CarouselServiceInterface
{
    private int $visibleCount = 0;
    private int $previousOffset = 0;
    private CarouselDataProviderInterface $carouselDataProvider;

    public function __construct(CarouselDataProviderInterface $carouselDataProvider)
    {
        $this->carouselDataProvider = $carouselDataProvider;
    }

    public function calculateCurrentOffset(bool $moveForward): ?int
    {
        $this->validate();
        $totalAmount = $this->carouselDataProvider->getTotalAmount();

        if ($totalAmount === 0) {
            return null;
        }

        // Total items is equal or less than visible items? Let's return 0, because all items should be returned
        if ($totalAmount <= $this->visibleCount) {
            return 0;
        }

        if ($moveForward) {
            return $this->calculateCurrentOffsetForward();
        }

        return $this->calculateCurrentOffsetBackward();
    }

    public function goBackward(): array
    {
        return $this->go(false);
    }

    public function goForward(): array
    {
        return $this->go(true);
    }

    public function setPreviousOffset(int $offset): void
    {
        $this->previousOffset = $offset;
    }

    public function setVisibleCount(int $count): void
    {
        $this->visibleCount = $count;
    }

    private function calculateCurrentOffsetBackward(): int
    {
        $result = $this->previousOffset - $this->visibleCount;
        $totalAmount = $this->carouselDataProvider->getTotalAmount();

        if ($result < 0) {
            return $result + $totalAmount;
        }

        return $result;
    }

    private function calculateCurrentOffsetForward(): int
    {
        $result = $this->previousOffset + $this->visibleCount;
        $totalAmount = $this->carouselDataProvider->getTotalAmount();

        if ($result > $totalAmount) {
            return $result - $totalAmount;
        }

        return $result;
    }

    private function go(bool $forward): array
    {
        $totalAmount = $this->carouselDataProvider->getTotalAmount();

        if ($totalAmount <= 0) {
            return [];
        }

        // Total items is equal or less than visible items? Let's return all available items
        if ($totalAmount <= $this->visibleCount) {
            return $this->carouselDataProvider->provide(0, $this->visibleCount);
        }

        $currentOffset = $this->calculateCurrentOffset($forward);

        $data = $this->carouselDataProvider->provide($currentOffset, $this->visibleCount);
        $dataCount = count($data);

        if ($dataCount < $this->visibleCount) {
            $missingCount = $this->visibleCount - $dataCount;

            $this->setVisibleCount($missingCount);
            $this->setPreviousOffset($missingCount * (-1));

            $data2 = $this->go(true);

            if ($forward) {
                return array_merge($data, $data2);
            }

            return array_merge($data2, $data);
        }

        return $data;
    }

    private function validate(): void
    {
        if ($this->visibleCount <= 0) {
            throw new VisibleCountNeedsToBeGreaterThanZeroException($this->visibleCount);
        }
    }
}
