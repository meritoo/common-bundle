<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Traits\Test\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Meritoo\CommonBundle\Traits\Test\Entity\EntityTestCaseTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @internal
 * @covers \Meritoo\CommonBundle\Traits\Test\Entity\EntityTestCaseTrait
 */
class EntityTestCaseTraitTest extends TestCase
{
    public function testDropDatabaseSchema(): void
    {
        $trait = $this->getMockedTrait('dropDatabaseSchema');

        $trait
            ->expects(self::once())
            ->method('dropDatabaseSchema')
        ;

        static::assertNull($trait->dropDatabaseSchema());
    }

    public function testGetEntityManager(): void
    {
        $trait = $this->getMockedTrait('getEntityManager');
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $trait
            ->expects(self::once())
            ->method('getEntityManager')
            ->willReturn($entityManager)
        ;

        static::assertInstanceOf(EntityManagerInterface::class, $trait->getEntityManager());
    }

    public function testGetRepository(): void
    {
        $trait = $this->getMockedTrait('getRepository');
        $repository = $this->createMock(ObjectRepository::class);

        $trait
            ->expects(self::once())
            ->method('getRepository')
            ->willReturn($repository)
        ;

        static::assertInstanceOf(ObjectRepository::class, $trait->getRepository(stdClass::class));
    }

    public function testPersistAndFlush(): void
    {
        $trait = $this->getMockedTrait('persistAndFlush');

        $trait
            ->expects(self::once())
            ->method('persistAndFlush')
        ;

        static::assertNull($trait->persistAndFlush(new stdClass()));
    }

    public function testUpdateDatabaseSchema(): void
    {
        $trait = $this->getMockedTrait('updateDatabaseSchema');

        $trait
            ->expects(self::once())
            ->method('updateDatabaseSchema')
        ;

        static::assertNull($trait->updateDatabaseSchema());
    }

    private function getMockedTrait(string $method): MockObject
    {
        return $this->getMockForTrait(EntityTestCaseTrait::class, [], '', true, true, true, [$method]);
    }
}
