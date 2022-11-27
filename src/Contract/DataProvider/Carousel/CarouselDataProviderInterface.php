<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Contract\DataProvider\Carousel;

/**
 * Interface/Contract of the data provider for carousel
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
interface CarouselDataProviderInterface
{
    public function getTotalAmount(): int;

    public function provide(int $offset, int $slidesCount): array;
}
