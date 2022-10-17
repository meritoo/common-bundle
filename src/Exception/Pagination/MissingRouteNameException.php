<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Pagination;

use Exception;
use Meritoo\CommonBundle\Contract\Service\PaginationServiceInterface;

/**
 * An exception used while name of route used to build urls for pagination is missing
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class MissingRouteNameException extends Exception
{
    public static function create(): self
    {
        $template = 'Cannot render pagination, because name of route used to build urls is missing. Did you provide the'
            .' route via %s::setRoute() method?';
        $message = sprintf($template, PaginationServiceInterface::class);

        return new self($message);
    }
}
