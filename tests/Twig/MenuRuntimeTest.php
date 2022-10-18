<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Twig;

use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Contract\Service\MenuServiceInterface;
use Meritoo\CommonBundle\Twig\MenuRuntime;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Test case for the runtime class related to MenuExtension Twig Extension
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Twig\MenuRuntime
 */
class MenuRuntimeTest extends TestCase
{
    use BaseTestCaseTrait;

    private MenuRuntime $menuRuntime;

    /**
     * @var MenuServiceInterface|MockObject
     */
    private $menuService;

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            MenuRuntime::class,
            OopVisibilityType::IS_PUBLIC,
            1,
            1
        );
    }

    /**
     * @dataProvider provideBooleanValue
     */
    public function testIsActive(bool $active): void
    {
        $this
            ->menuService
            ->expects(self::once())
            ->method('isActive')
            ->willReturn($active)
        ;

        self::assertSame($active, $this->menuRuntime->isActive('/test', 'test_route'));
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->menuService = $this->createMock(MenuServiceInterface::class);
        $this->menuRuntime = new MenuRuntime($this->menuService);
    }
}
