<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Twig extension that provides functions and filters for common operations
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class CommonExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        $filters = [
            1 => [
                CommonRuntime::class,
                'verifyEmptyValue',
            ],
        ];

        return array_merge(parent::getFilters(), [
            new TwigFilter('meritoo_common_empty_value', $filters[1]),
        ]);
    }
}
