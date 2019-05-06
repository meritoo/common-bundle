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
 * Twig extension related to the FormService service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class FormExtension extends AbstractExtension
{
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $functions = [
            1 => [
                FormRuntime::class,
                'isHtml5ValidationEnabled',
            ],
        ];

        return array_merge(parent::getFunctions(), [
            new TwigFunction('meritoo_common_form_is_html5_validation_enabled', $functions[1]),
        ]);
    }
}
