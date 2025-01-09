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
 * Twig extension that provides functions and filters for html operations
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class HtmlExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        $filters = [
            1 => [
                [HtmlRuntime::class, 'attributes2string',],
                ['is_safe' => ['html']],
            ],
        ];

        return array_merge(parent::getFilters(), [
            new TwigFilter('meritoo_common_html_attributes_2_string', $filters[1][0], $filters[1][1]),
        ]);
    }
}
