<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Twig extension related to the ApplicationService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class ApplicationExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions(): array
    {
        $functions = [
            1 => [
                ApplicationRuntime::class,
                'getDescriptor',
            ],
        ];

        return array_merge(parent::getFunctions(), [
            new TwigFunction('meritoo_common_application_descriptor', $functions[1]),
        ]);
    }
}
