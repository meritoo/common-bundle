<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Exception\Controller\BaseController;

use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use RuntimeException;

/**
 * An exception used while redirection to url of referer cannot be done, because this url is empty
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class CannotRedirectToEmptyRefererUrlException extends RuntimeException
{
    /**
     * Creates exception
     *
     * @return CannotRedirectToEmptyRefererUrlException
     */
    public static function create(): CannotRedirectToEmptyRefererUrlException
    {
        $template = 'Redirection to url of referer cannot be done, because this url is empty. Did you store url of' .
            ' referer using %s::%s() method or does request provide url of referer?';

        $message = sprintf($template, RequestServiceInterface::class, 'storeRefererUrl');

        return new static($message);
    }
}
