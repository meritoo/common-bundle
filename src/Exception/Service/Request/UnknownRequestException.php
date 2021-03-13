<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Service\Request;

use Exception;

/**
 * An exception used while request is required, but is unknown
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
final class UnknownRequestException extends Exception
{
    public function __construct()
    {
        parent::__construct('Cannot get current request, because it is unknown');
    }
}
