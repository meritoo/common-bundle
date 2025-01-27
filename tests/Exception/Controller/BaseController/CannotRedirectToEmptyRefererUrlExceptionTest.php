<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Exception\Controller\BaseController;

use Meritoo\Common\Enums\OopVisibility;
use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\Contract\Service\RequestServiceInterface;
use Meritoo\CommonBundle\Exception\Controller\BaseController\CannotRedirectToEmptyRefererUrlException;

/**
 * Test case of an exception used while redirection to url of referer cannot be done, because this url is empty
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Exception\Controller\BaseController\CannotRedirectToEmptyRefererUrlException
 */
class CannotRedirectToEmptyRefererUrlExceptionTest extends BaseTestCase
{
    public function testConstructorVisibilityAndArguments(): void
    {
        static::assertConstructorVisibilityAndArguments(
            CannotRedirectToEmptyRefererUrlException::class,
            OopVisibility::Public,
            3,
        );
    }

    public function testCreate(): void
    {
        $template = 'Redirection to url of referer cannot be done, because this url is empty. Did you store url of'.
            ' referer using %s::%s() method or does request provide url of referer?';

        $message = sprintf($template, RequestServiceInterface::class, 'storeRefererUrl');

        $exception = CannotRedirectToEmptyRefererUrlException::create();
        static::assertSame($message, $exception->getMessage());
    }
}
