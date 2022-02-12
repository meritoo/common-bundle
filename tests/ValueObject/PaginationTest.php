<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\ValueObject;

use Meritoo\Common\Test\Base\BaseTestCase;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectCurrentPageException;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectPerPageException;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectTotalAmountException;
use Meritoo\CommonBundle\ValueObject\Pagination;

/**
 * Test case of class that represents core parameters used to serve pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @internal
 * @covers    \Meritoo\CommonBundle\ValueObject\Pagination
 */
class PaginationTest extends BaseTestCase
{
    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            Pagination::class,
            OopVisibilityType::IS_PUBLIC,
            3,
            2
        );
    }

    /**
     * @param int    $totalAmount
     * @param int    $perPage
     * @param int    $currentPage
     * @param string $expectedExceptionClass
     *
     * @dataProvider provideIncorrectParametersToCreate
     */
    public function testCreateUsingIncorrectParameters(
        int $totalAmount,
        int $perPage,
        int $currentPage,
        string $expectedExceptionClass
    ): void {
        $this->expectException($expectedExceptionClass);
        new Pagination($totalAmount, $perPage, $currentPage);
    }

    public function testGetPerPage(): void
    {
        $perPage = 10;
        $pagination = new Pagination(50, $perPage);

        static::assertSame($perPage, $pagination->getPerPage());
    }

    /**
     * @param string $description
     * @param int    $expected
     * @param int    $totalAmount
     * @param int    $perPage
     * @param int    $currentPage
     *
     * @dataProvider providePaginationToCurrentPage
     */
    public function testGetCurrentPage(
        string $description,
        int $expected,
        int $totalAmount,
        int $perPage,
        int $currentPage = 1
    ): void {
        $pagination = new Pagination($totalAmount, $perPage, $currentPage);
        static::assertSame($pagination->getCurrentPage(), $expected, $description);
    }

    /**
     * @param string $description
     * @param int    $expected
     * @param int    $totalAmount
     * @param int    $perPage
     * @param int    $currentPage
     *
     * @dataProvider providePaginationToCalculateOffset
     */
    public function testCalculateOffset(
        string $description,
        int $expected,
        int $totalAmount,
        int $perPage,
        int $currentPage = 1
    ): void {
        $pagination = new Pagination($totalAmount, $perPage, $currentPage);
        static::assertSame($pagination->calculateOffset(), $expected, $description);
    }

    /**
     * @param string $description
     * @param int    $expected
     * @param int    $totalAmount
     * @param int    $perPage
     * @param int    $currentPage
     *
     * @dataProvider providePaginationToCalculatePagesCount
     */
    public function testCalculatePagesCount(
        string $description,
        int $expected,
        int $totalAmount,
        int $perPage,
        int $currentPage = 1
    ): void {
        $pagination = new Pagination($totalAmount, $perPage, $currentPage);
        static::assertSame($pagination->calculatePagesCount(), $expected, $description);
    }

    /**
     * @param string $description
     * @param bool   $expected
     * @param int    $page
     * @param int    $totalAmount
     * @param int    $perPage
     * @param int    $currentPage
     *
     * @dataProvider providePaginationToValidatePageNumber
     */
    public function testIsValidPage(
        string $description,
        bool $expected,
        int $page,
        int $totalAmount,
        int $perPage,
        int $currentPage = 1
    ): void {
        $pagination = new Pagination($totalAmount, $perPage, $currentPage);
        static::assertSame($pagination->isValidPage($page), $expected, $description);
    }

    public function provideIncorrectParametersToCreate(): ?\Generator
    {
        yield[
            -1,
            -1,
            -1,
            IncorrectTotalAmountException::class,
        ];

        yield[
            0,
            -1,
            -1,
            IncorrectPerPageException::class,
        ];

        yield[
            0,
            0,
            -1,
            IncorrectPerPageException::class,
        ];

        yield[
            0,
            5,
            -1,
            IncorrectCurrentPageException::class,
        ];

        yield[
            0,
            5,
            0,
            IncorrectCurrentPageException::class,
        ];
    }

    public function providePaginationToCurrentPage(): ?\Generator
    {
        yield[
            'Default value of current page number',
            1,
            10,
            4,
        ];

        yield[
            'Custom value of current page number',
            2,
            10,
            4,
            2,
        ];
    }

    public function providePaginationToCalculateOffset(): ?\Generator
    {
        yield[
            'Total amount: 50, per page: 10, page number: default',
            0,
            50,
            10,
        ];

        yield[
            'Total amount: 50, per page: 10, page number: 1',
            0,
            50,
            10,
            1,
        ];

        yield[
            'Total amount: 50, per page: 10, page number: 2',
            10,
            50,
            10,
            2,
        ];

        yield[
            'Total amount: 50, per page: 10, page number: 10',
            90,
            50,
            10,
            10,
        ];
    }

    public function providePaginationToCalculatePagesCount(): ?\Generator
    {
        yield[
            'Total amount: 50, per page: 5, page number: default',
            10,
            50,
            5,
        ];

        yield[
            'Total amount: 10, per page: 4, page number: default',
            3,
            10,
            4,
        ];

        yield[
            'Total amount: 10, per page: 4, page number: 3',
            3,
            10,
            4,
            3,
        ];
    }

    public function providePaginationToValidatePageNumber(): ?\Generator
    {
        yield[
            'Total amount: 10, per page: 4, page: -1',
            false,
            -1,
            10,
            4,
        ];

        yield[
            'Total amount: 10, per page: 4, page: 0',
            false,
            0,
            10,
            4,
        ];

        yield [
            'Total amount: 10, per page: 4, page: 3',
            true,
            3,
            10,
            4,
        ];

        yield [
            'Total amount: 0, per page: 4, page: 1',
            true,
            1,
            0,
            4,
        ];
    }
}
