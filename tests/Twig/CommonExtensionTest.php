<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\CommonBundle\Twig\CommonExtension;
use Meritoo\CommonBundle\Twig\CommonRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\TwigFilter;

/**
 * Test case for the twig extension that provides functions and filters for common operations
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
class CommonExtensionTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    public function testConstructor(): void
    {
        static::assertHasNoConstructor(CommonExtension::class);
    }

    public function testGetFilters(): void
    {
        $filters = static::$container
            ->get(CommonExtension::class)
            ->getFilters();

        /* @var TwigFilter $verifyEmptyValue */
        $verifyEmptyValue = $filters[0];

        static::assertCount(1, $filters);
        static::assertInstanceOf(TwigFilter::class, $verifyEmptyValue);
        static::assertSame('meritoo_common_empty_value', $verifyEmptyValue->getName());
        static::assertSame([
            CommonRuntime::class,
            'verifyEmptyValue',
        ], $verifyEmptyValue->getCallable());
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        static::bootKernel();
    }
}
