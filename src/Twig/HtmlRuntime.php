<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Twig;

use Meritoo\Common\Utilities\Arrays;
use Twig\Extension\RuntimeExtensionInterface;

/**
 * Runtime class related to HtmlExtension Twig Extension.
 * Required to create lazy-loaded Twig Extension.
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class HtmlRuntime implements RuntimeExtensionInterface
{
    public function attributes2string(array $attributes): ?string
    {
        return Arrays::valuesKeys2string($attributes, ' ', '=', '"');
    }
}
