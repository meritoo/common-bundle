<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Carousel;

use Exception;

/**
 * An exception used while count of visible items is less than or equal zero
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class VisibleCountNeedsToBeGreaterThanZeroException extends Exception
{
    public function __construct(int $visibleCount)
    {
        parent::__construct(sprintf('Visible count needs to be greater than 0, but %d given', $visibleCount));
    }
}
