<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service\Base;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\CommonBundle\Service\Base\BaseService;
use Meritoo\Test\CommonBundle\Service\Base\BaseService\RealService;

/**
 * Test case for the groundwork of Symfony's service
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers \Meritoo\CommonBundle\Service\Base\BaseService
 */
class BaseServiceTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertHasNoConstructor(BaseService::class);
    }

    public function testCreateNewInstance(): void
    {
        $realService = new RealService();
        static::assertInstanceOf(BaseService::class, $realService);
    }
}
