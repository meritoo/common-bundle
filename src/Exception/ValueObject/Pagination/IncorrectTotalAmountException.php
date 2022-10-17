<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\ValueObject\Pagination;

/**
 * An exception used while the "total amount" parameter of pagination has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class IncorrectTotalAmountException extends BaseIncorrectParameterException
{
    protected function getParameterName(): string
    {
        return 'total amount';
    }

    protected function isZeroAllowed(): bool
    {
        return true;
    }
}
