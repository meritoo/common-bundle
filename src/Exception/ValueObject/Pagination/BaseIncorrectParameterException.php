<?php

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\ValueObject\Pagination;

use Exception;

/**
 * Base exception used while parameter of pagination, e.g. total amount, has incorrect value
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo.pl <http://www.meritoo.pl>
 *
 * @codeCoverageIgnore
 */
abstract class BaseIncorrectParameterException extends Exception
{
    public function __construct(int $value)
    {
        $name = $this->getParameterName();
        $zeroAllowed = $this->isZeroAllowed();

        $template = 'The \'%s\' parameter of pagination should be greater than %s0, but %d was provided. Is there'
            .' everything ok?';

        $zeroPart = $zeroAllowed ? 'or equal ' : '';
        $message = sprintf($template, $name, $zeroPart, $value);

        parent::__construct($message);
    }

    abstract protected function getParameterName(): string;

    protected function isZeroAllowed(): bool
    {
        return false;
    }
}
