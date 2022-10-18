<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Service;

use Generator;
use Meritoo\Common\Traits\Test\Base\BaseTestCaseTrait;
use Meritoo\Common\Type\OopVisibilityType;
use Meritoo\Common\Utilities\Reflection;
use Meritoo\CommonBundle\Contract\Service\PaginationServiceInterface;
use Meritoo\CommonBundle\Exception\Pagination\MissingPerPageAmountException;
use Meritoo\CommonBundle\Exception\Pagination\MissingRouteNameException;
use Meritoo\CommonBundle\Exception\Pagination\MissingTemplatePathException;
use Meritoo\CommonBundle\Exception\Pagination\MissingTotalAmountException;
use Meritoo\CommonBundle\Exception\ValueObject\Pagination\IncorrectTotalAmountException;
use Meritoo\CommonBundle\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

/**
 * Test case for the service that serves pagination
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 *
 * @covers    \Meritoo\CommonBundle\Service\PaginationService
 */
class PaginationServiceTest extends KernelTestCase
{
    use BaseTestCaseTrait;

    private PaginationServiceInterface $paginationService;

    public function provideIncorrectCurrentPageForRender(): Generator
    {
        yield 'negative page number when there are no items' => [0, -10];
        yield 'negative page number' => [10, -10];
        yield 'yet another negative page number' => [10, -1];
        yield '0 as page number' => [10, 0];
        yield 'first when there are no items' => [0, 1];
        yield 'out of range page number' => [10, 4];
    }

    public function providePageForValidation(): Generator
    {
        yield '0 as page number when there are no items' => [0, 0, false];
        yield 'negative page number when there are no items' => [0, -1, false];
        yield 'negative page number' => [10, -1, false];
        yield '0 as page number' => [10, 0, false];
        yield '1 as page number when there are no items' => [0, 1, true];
        yield '10 as page number when there are no items' => [0, 10, false];
        yield '2 as page number when there is 1 page only' => [2, 2, false];
        yield '1 as page number when there is 1 page only' => [2, 1, true];
        yield '10 as page number when there are 9 pages only' => [50, 10, false];
        yield '9 as page number when there are 9 pages only' => [50, 9, true];
    }

    public function providePerPage(): Generator
    {
        yield 'negative value' => [-10];
        yield 'yet another negative value' => [-1];
        yield 'zero' => [0];
        yield 'positive value' => [1];
        yield 'yet another positive value' => [10];
    }

    public function testConstructor(): void
    {
        static::assertConstructorVisibilityAndArguments(
            PaginationService::class,
            OopVisibilityType::IS_PUBLIC,
            5,
            2
        );
    }

    public function testGetPerPage(): void
    {
        self::assertSame(6, $this->paginationService->getPerPage());
    }

    public function testGetPerPageUsingDefaults(): void
    {
        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $result = static::getContainer()
            ->get(PaginationServiceInterface::class)
            ->getPerPage()
        ;

        self::assertNull($result);
    }

    /**
     * @dataProvider providePageForValidation
     */
    public function testIsValidPage(int $totalAmount, int $page, bool $expected): void
    {
        $this->paginationService->setTotalAmount($totalAmount);
        $result = $this->paginationService->isValidPage($page);

        self::assertSame($expected, $result);
    }

    public function testIsValidPageIfPerPageIsUnknown(): void
    {
        $this->expectException(MissingPerPageAmountException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        static::getContainer()
            ->get(PaginationServiceInterface::class)
            ->isValidPage(1)
        ;
    }

    public function testIsValidPageIfTotalAmountIsUnknown(): void
    {
        $this->expectException(MissingTotalAmountException::class);
        $this->paginationService->isValidPage(1);
    }

    /**
     * @dataProvider providePageForValidation
     */
    public function testIsValidPageUsingDefaults(int $totalAmount, int $page, bool $expected): void
    {
        $this->expectException(MissingPerPageAmountException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $service = static::getContainer()
            ->get(PaginationServiceInterface::class)
        ;

        $service->setTotalAmount($totalAmount);
        $result = $service->isValidPage($page);

        self::assertSame($expected, $result);
    }

    public function testRenderPagination(): void
    {
        $this->paginationService->setTotalAmount(15);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');
        $result = $this->paginationService->renderPagination();

        $expected = '<ul>'
            .'<li class="current"><a href="/test/of/pagination">1</a></li>'
            .'<li><a href="/test/of/pagination/2">2</a></li>'
            .'<li><a href="/test/of/pagination/3">3</a></li>'
            .'<li class="page-item go-to-next"><a href="/test/of/pagination/2">&rightarrow;</a></li>'
            .'</ul>';

        self::assertSame($expected, $result);
    }

    public function testRenderPaginationIfCurrentPageIsFirst(): void
    {
        $totalAmount = 100;
        $currentPage = 1;

        $this->paginationService->setTotalAmount($totalAmount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');

        $expected = '<ul>'
            .'<li class="current"><a href="/test/of/pagination">1</a></li>'
            .'<li><a href="/test/of/pagination/2">2</a></li>'
            .'<li><a href="/test/of/pagination/17">17</a></li>'
            .'<li class="page-item go-to-next"><a href="/test/of/pagination/2">&rightarrow;</a></li>'
            .'</ul>';

        $result = $this->paginationService->renderPagination($currentPage);
        self::assertSame($expected, $result);
    }

    /**
     * @dataProvider provideIncorrectCurrentPageForRender
     */
    public function testRenderPaginationIfCurrentPageIsIncorrect(int $totalAmount, int $currentPage): void
    {
        $this->paginationService->setTotalAmount($totalAmount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');

        $result = $this->paginationService->renderPagination($currentPage);
        self::assertSame('', $result);
    }

    public function testRenderPaginationIfCurrentPageIsLast(): void
    {
        $totalAmount = 100;
        $currentPage = 17;

        $this->paginationService->setTotalAmount($totalAmount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');

        $expected = '<ul>'
            .'<li class="page-item go-to-previous"><a href="/test/of/pagination/16">&leftarrow;</a></li>'
            .'<li><a href="/test/of/pagination">1</a></li>'
            .'<li><a href="/test/of/pagination/16">16</a></li>'
            .'<li class="current"><a href="/test/of/pagination/17">17</a></li>'
            .'</ul>';

        $result = $this->paginationService->renderPagination($currentPage);
        self::assertSame($expected, $result);
    }

    public function testRenderPaginationIfNearbyCurrentPageCountIsCustom(): void
    {
        $totalAmount = 100;
        $currentPage = 10;
        $nearbyCurrentPageCount = 1;

        $this->paginationService->setTotalAmount($totalAmount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');
        $this->paginationService->setNearbyCurrentPageCount($nearbyCurrentPageCount);

        $expected = '<ul>'
            .'<li class="page-item go-to-previous"><a href="/test/of/pagination/9">&leftarrow;</a></li>'
            .'<li><a href="/test/of/pagination">1</a></li>'
            .'<li><a href="/test/of/pagination/9">9</a></li>'
            .'<li class="current"><a href="/test/of/pagination/10">10</a></li>'
            .'<li><a href="/test/of/pagination/11">11</a></li>'
            .'<li><a href="/test/of/pagination/17">17</a></li>'
            .'<li class="page-item go-to-next"><a href="/test/of/pagination/11">&rightarrow;</a></li>'
            .'</ul>';

        $result = $this->paginationService->renderPagination($currentPage);
        self::assertSame($expected, $result);
    }

    public function testRenderPaginationIfRouteDoesNotExist(): void
    {
        $this->expectException(RouteNotFoundException::class);

        $this->paginationService->setTotalAmount(10);
        $this->paginationService->setRoute('abc');
        $this->paginationService->renderPagination();
    }

    public function testRenderPaginationIfRouteIsAnEmptyString(): void
    {
        $this->expectException(MissingRouteNameException::class);

        $this->paginationService->setTotalAmount(10);
        $this->paginationService->setRoute('');
        $this->paginationService->renderPagination();
    }

    public function testRenderPaginationIfRouteIsUnknown(): void
    {
        $this->expectException(MissingRouteNameException::class);

        $this->paginationService->setTotalAmount(10);
        $this->paginationService->renderPagination();
    }

    public function testRenderPaginationIfTemplatePathIsCustom(): void
    {
        $totalAmount = 10;
        $currentPage = 2;

        $this->paginationService->setTotalAmount($totalAmount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');
        $this->paginationService->setTemplatePath('pagination_custom.html.twig');

        $expected = '<div class="pagination">'
            .'<div class="page-item go-to-previous"><a href="/test/of/pagination">&leftarrow;</a></div>'
            .'<div><a href="/test/of/pagination">1</a></div>'
            .'<div class="current"><a href="/test/of/pagination/2">2</a></div>'
            .'</div>';

        $result = $this->paginationService->renderPagination($currentPage);
        self::assertSame($expected, $result);
    }

    public function testRenderPaginationIfTotalAmountIsLessThanOnePageSize(): void
    {
        // Size of one pagination's page equals 6, so pagination is not rendered
        $this->paginationService->setTotalAmount(6);

        $result = $this->paginationService->renderPagination();
        self::assertSame('', $result);
    }

    public function testRenderPaginationIfTotalAmountIsNegative(): void
    {
        $this->expectException(IncorrectTotalAmountException::class);

        $this->paginationService->setTotalAmount(-1);
        $this->paginationService->renderPagination();
    }

    public function testRenderPaginationIfTotalAmountIsUnknown(): void
    {
        $this->expectException(MissingTotalAmountException::class);
        $this->paginationService->renderPagination();
    }

    public function testRenderPaginationPageNumberIsDefault(): void
    {
        $amount = 10; // 2 pages per 6 items each
        $this->paginationService->setTotalAmount($amount);
        $this->paginationService->setRoute('test.pagination_service.render_pagination');

        $expected = '<ul>'
            .'<li class="current"><a href="/test/of/pagination">1</a></li>'
            .'<li><a href="/test/of/pagination/2">2</a></li>'
            .'<li class="page-item go-to-next"><a href="/test/of/pagination/2">&rightarrow;</a></li>'
            .'</ul>';

        $result = $this->paginationService->renderPagination();
        self::assertSame($expected, $result);
    }

    public function testRenderPaginationUsingDefaults(): void
    {
        $this->expectException(MissingPerPageAmountException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $service = static::getContainer()
            ->get(PaginationServiceInterface::class)
        ;

        $service->renderPagination();
    }

    public function testRenderPaginationUsingDefaultsAndCustomPerPage(): void
    {
        $this->expectException(MissingTemplatePathException::class);

        static::bootKernel([
            'environment' => 'defaults',
        ]);

        $service = static::getContainer()
            ->get(PaginationServiceInterface::class)
        ;

        $service->setTotalAmount(10);
        $service->setPerPage(2);
        $service->renderPagination();
    }

    /**
     * @dataProvider providePerPage
     */
    public function testSetPerPage(int $perPage): void
    {
        $this->paginationService->setPerPage($perPage);
        $result = $this->paginationService->getPerPage();

        self::assertSame($perPage, $result);
    }

    public function testSetRoute(): void
    {
        $route = Reflection::getPropertyValue($this->paginationService, 'route');
        self::assertSame('', $route);

        $anotherRoute = 'abc';
        $this->paginationService->setRoute($anotherRoute);

        $route = Reflection::getPropertyValue($this->paginationService, 'route');
        self::assertSame($anotherRoute, $route);
    }

    public function testSetTemplatePath(): void
    {
        $templatePath = Reflection::getPropertyValue($this->paginationService, 'templatePath');
        self::assertSame('pagination.html.twig', $templatePath);

        $anotherTemplatePath = 'abc';
        $this->paginationService->setTemplatePath($anotherTemplatePath);

        $templatePath = Reflection::getPropertyValue($this->paginationService, 'templatePath');
        self::assertSame($anotherTemplatePath, $templatePath);
    }

    public function testSetTotalAmount(): void
    {
        $amount = Reflection::getPropertyValue($this->paginationService, 'totalAmount');
        self::assertNull($amount);

        $anotherAmount = -1;
        $this->paginationService->setTotalAmount($anotherAmount);

        $amount = Reflection::getPropertyValue($this->paginationService, 'totalAmount');
        self::assertSame($anotherAmount, $amount);
    }

    protected function setUp(): void
    {
        parent::setUp();
        static::bootKernel();

        /** @var PaginationServiceInterface $paginationService */
        $paginationService = static::getContainer()->get(PaginationServiceInterface::class);

        $this->paginationService = $paginationService;
    }
}
