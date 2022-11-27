<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
use Meritoo\Common\Utilities\Reflection;
use Meritoo\CommonBundle\Contract\DataProvider\Carousel\CarouselDataProviderInterface;
use Meritoo\CommonBundle\Exception\Carousel\VisibleCountNeedsToBeGreaterThanZeroException;
use Meritoo\CommonBundle\Service\CarouselService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * Test case for the service that serves carousel
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\Service\CarouselService
 */
class CarouselServiceTest extends TestCase
{
    private CarouselService $service;

    /** @var CarouselDataProviderInterface|MockObject */
    private $carouselDataProvider;

    public function provideDataToCalculateCurrentOffsetBackward(): Generator
    {
        yield [
            4,
            4,
            100,
            0,
        ];

        yield [
            6,
            4,
            100,
            2,
        ];

        yield [
            12,
            4,
            100,
            8,
        ];
    }

    public function provideDataToCalculateCurrentOffsetBackwardIfOffsetIsMarginal(): Generator
    {
        yield [
            0,
            4,
            10,
            6,
        ];

        yield [
            2,
            4,
            5,
            3,
        ];
    }

    public function provideDataToCalculateCurrentOffsetForward(): Generator
    {
        yield [
            0,
            4,
            100,
            4,
        ];

        yield [
            2,
            4,
            100,
            6,
        ];

        yield [
            8,
            4,
            100,
            12,
        ];
    }

    public function provideDataToCalculateCurrentOffsetForwardIfOffsetIsMarginal(): Generator
    {
        yield [
            8,
            4,
            10,
            2,
        ];

        yield [
            10,
            4,
            10,
            4,
        ];

        yield [
            4,
            4,
            5,
            3,
        ];

        yield [
            4,
            4,
            8,
            8,
        ];
    }

    public function provideGoForwardArgumentsIfAllItemsCountIsLessThanOrEqualsZero(): Generator
    {
        yield [
            0,
            10,
            0,
        ];

        yield [
            0,
            10,
            -1,
        ];

        yield [
            0,
            10,
            -10,
        ];
    }

    /**
     * @param int $offset
     * @param int $visibleCount
     * @param int $total
     * @param int $expected
     *
     * @dataProvider provideDataToCalculateCurrentOffsetBackward
     */
    public function testCalculateCurrentOffsetBackward(int $offset, int $visibleCount, int $total, int $expected): void
    {
        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $result = $this->service->calculateCurrentOffset(false);
        self::assertSame($expected, $result);
    }

    /**
     * @param int $offset
     * @param int $visibleCount
     * @param int $total
     * @param int $expected
     *
     * @dataProvider provideDataToCalculateCurrentOffsetBackwardIfOffsetIsMarginal
     */
    public function testCalculateCurrentOffsetBackwardIfOffsetIsMarginal(
        int $offset,
        int $visibleCount,
        int $total,
        int $expected
    ): void {
        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $result = $this->service->calculateCurrentOffset(false);
        self::assertSame($expected, $result);
    }

    public function testCalculateCurrentOffsetBackwardIfThereIsLessItemsThanVisible(): void
    {
        $this->service->setPreviousOffset(0);
        $this->service->setVisibleCount(4);

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn(2)
        ;

        $result = $this->service->calculateCurrentOffset(false);
        $expected = 0;

        self::assertSame($expected, $result);
    }

    public function testCalculateCurrentOffsetBackwardIfThereIsNoData(): void
    {
        $this->service->setPreviousOffset(0);
        $this->service->setVisibleCount(4);

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn(0)
        ;

        $result = $this->service->calculateCurrentOffset(false);
        self::assertNull($result);
    }

    public function testCalculateCurrentOffsetBackwardIfVisibleCountIsNegativeValue(): void
    {
        $this->expectException(VisibleCountNeedsToBeGreaterThanZeroException::class);
        $this->expectExceptionMessage('Visible count needs to be greater than 0, but 0 given');

        $this->service->calculateCurrentOffset(true);
    }

    /**
     * @param int $offset
     * @param int $visibleCount
     * @param int $total
     * @param int $expected
     *
     * @dataProvider provideDataToCalculateCurrentOffsetForward
     */
    public function testCalculateCurrentOffsetForward(int $offset, int $visibleCount, int $total, int $expected): void
    {
        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $result = $this->service->calculateCurrentOffset(true);
        self::assertSame($expected, $result);
    }

    /**
     * @param int $offset
     * @param int $visibleCount
     * @param int $total
     * @param int $expected
     *
     * @dataProvider provideDataToCalculateCurrentOffsetForwardIfOffsetIsMarginal
     */
    public function testCalculateCurrentOffsetForwardIfOffsetIsMarginal(
        int $offset,
        int $visibleCount,
        int $total,
        int $expected
    ): void {
        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $result = $this->service->calculateCurrentOffset(true);
        self::assertSame($expected, $result);
    }

    public function testCalculateCurrentOffsetForwardIfThereIsLessItemsThanVisible(): void
    {
        $this->service->setPreviousOffset(0);
        $this->service->setVisibleCount(4);

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn(2)
        ;

        $result = $this->service->calculateCurrentOffset(true);
        $expected = 0;

        self::assertSame($expected, $result);
    }

    public function testCalculateCurrentOffsetForwardIfThereIsNoData(): void
    {
        $this->service->setPreviousOffset(0);
        $this->service->setVisibleCount(4);

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn(0)
        ;

        $result = $this->service->calculateCurrentOffset(true);
        self::assertNull($result);
    }

    public function testCalculateCurrentOffsetForwardIfVisibleCountIsNegativeValue(): void
    {
        $this->expectException(VisibleCountNeedsToBeGreaterThanZeroException::class);
        $this->expectExceptionMessage('Visible count needs to be greater than 0, but 0 given');

        $this->service->calculateCurrentOffset(true);
    }

    public function testCalculateCurrentOffsetIfTotalAmountIsEqualVisibleCount(): void
    {
        $this->service->setVisibleCount(5);

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn(5)
        ;

        $result = $this->service->calculateCurrentOffset(true);
        self::assertSame(0, $result);
    }

    public function testGoBackward(): void
    {
        $offset = 0;
        $visibleCount = 4;
        $total = 20;
        $currentOffset = 16;

        $expected = [
            new stdClass(),
            new stdClass(),
            new stdClass(),
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::exactly(3))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('provide')
            ->with($currentOffset, $visibleCount)
            ->willReturn($expected)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goBackward();
        self::assertSame($expected, $result);
    }

    public function testGoBackwardIfOffsetIsMarginal(): void
    {
        $offset = 2;
        $visibleCount = 3;
        $total = 10;

        $data1 = [
            new stdClass(),
        ];

        $data2 = [
            new stdClass(),
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::exactly(6))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('provide')
            ->withConsecutive(
                [9, 3], // 1st attempt - returns 1 item only, because there are 10 all items
                [0, 2]  // 2nd attempt - returns 2 missing items
            )
            ->willReturnOnConsecutiveCalls(
                $data1,
                $data2
            )
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goBackward();
        $expected = array_merge($data2, $data1);

        self::assertSame($expected, $result);
    }

    public function testGoBackwardIfThereIsLessItemsThanVisible(): void
    {
        $offset = 0;
        $visibleCount = 3;
        $total = 1;

        $expected = [
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('provide')
            ->with(0, $visibleCount)
            ->willReturn($expected)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goBackward();
        self::assertSame($expected, $result);
    }

    public function testGoBackwardIfThereIsNoData(): void
    {
        $offset = 6;
        $visibleCount = 3;
        $total = 0;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goBackward();
        $expected = [];

        self::assertSame($expected, $result);
    }

    public function testGoForward(): void
    {
        $offset = 0;
        $visibleCount = 4;
        $total = 20;
        $currentOffset = 4;

        $expected = [
            new stdClass(),
            new stdClass(),
            new stdClass(),
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::exactly(3))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('provide')
            ->with($currentOffset, $visibleCount)
            ->willReturn($expected)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        self::assertSame($expected, $result);
    }

    public function testGoForwardIfAllItemsCountEqualsVisibleCount(): void
    {
        $offset = 0;
        $visibleCount = 20;
        $total = 20;

        $expected = [
            new stdClass(),
            new stdClass(),
            new stdClass(),
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('provide')
            ->with($total - $visibleCount, $visibleCount)
            ->willReturn($expected)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        self::assertSame($expected, $result);
    }

    /**
     * @dataProvider provideGoForwardArgumentsIfAllItemsCountIsLessThanOrEqualsZero
     */
    public function testGoForwardIfAllItemsCountIsLessThanOrEqualsZero(int $offset, int $visibleCount, int $total): void
    {
        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::never())
            ->method('provide')
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        self::assertSame([], $result);
    }

    public function testGoForwardIfOffsetIsMarginal(): void
    {
        $offset = 6;
        $visibleCount = 3;
        $total = 10;

        $data1 = [
            new stdClass(),
        ];

        $data2 = [
            new stdClass(),
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::exactly(6))
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::exactly(2))
            ->method('provide')
            ->withConsecutive(
                [9, 3], // 1st attempt - returns 1 item only, because there are 10 all items
                [0, 2]  // 2nd attempt - returns 2 missing items
            )
            ->willReturnOnConsecutiveCalls(
                $data1,
                $data2
            )
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        $expected = array_merge($data1, $data2);

        self::assertSame($expected, $result);
    }

    public function testGoForwardIfThereIsLessItemsThanVisible(): void
    {
        $offset = 0;
        $visibleCount = 3;
        $total = 1;

        $expected = [
            new stdClass(),
        ];

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('provide')
            ->with(0, $visibleCount)
            ->willReturn($expected)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        self::assertSame($expected, $result);
    }

    public function testGoForwardIfThereIsNoData(): void
    {
        $offset = 6;
        $visibleCount = 3;
        $total = 0;

        $this
            ->carouselDataProvider
            ->expects(self::once())
            ->method('getTotalAmount')
            ->willReturn($total)
        ;

        $this->service->setPreviousOffset($offset);
        $this->service->setVisibleCount($visibleCount);

        $result = $this->service->goForward();
        $expected = [];

        self::assertSame($expected, $result);
    }

    public function testSetPreviousOffset(): void
    {
        $before = Reflection::getPropertyValue($this->service, 'previousOffset', true);

        $offset = 4;
        $this->service->setPreviousOffset($offset);
        $after = Reflection::getPropertyValue($this->service, 'previousOffset', true);

        self::assertSame(0, $before);
        self::assertSame($offset, $after);
    }

    public function testSetVisibleCount(): void
    {
        $before = Reflection::getPropertyValue($this->service, 'visibleCount', true);

        $visibleCount = 4;
        $this->service->setVisibleCount($visibleCount);
        $after = Reflection::getPropertyValue($this->service, 'visibleCount', true);

        self::assertSame(0, $before);
        self::assertSame($visibleCount, $after);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->carouselDataProvider = $this->createMock(CarouselDataProviderInterface::class);
        $this->service = new CarouselService($this->carouselDataProvider);
    }
}
