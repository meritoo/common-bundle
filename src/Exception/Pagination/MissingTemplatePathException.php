<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Pagination;

use Exception;
use Meritoo\CommonBundle\Contract\Service\PaginationServiceInterface;

/**
 * An exception used while template path used to render pagination is missing
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class MissingTemplatePathException extends Exception
{
    public static function create(): self
    {
        $template = 'Cannot render pagination, because path of template is missing. Did you provide the path in'
            .' configuration or via %s::setTemplatePath() method?';
        $message = sprintf($template, PaginationServiceInterface::class);

        return new self($message);
    }
}
