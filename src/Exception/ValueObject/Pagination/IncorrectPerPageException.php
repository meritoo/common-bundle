<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\ValueObject\Pagination;

/**
 * An exception used while the "per page" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 */
final class IncorrectPerPageException extends BaseIncorrectParameterException
{
    protected function getParameterName(): string
    {
        return 'per page';
    }
}
