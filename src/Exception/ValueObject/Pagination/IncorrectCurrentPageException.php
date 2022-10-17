<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\ValueObject\Pagination;

/**
 * An exception used while the "current page" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class IncorrectCurrentPageException extends BaseIncorrectParameterException
{
    protected function getParameterName(): string
    {
        return 'current page';
    }
}
