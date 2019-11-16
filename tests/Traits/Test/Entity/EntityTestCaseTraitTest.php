<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\Test\CommonBundle\Traits\Test\Entity;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Meritoo\CommonBundle\Traits\Test\Entity\EntityTestCaseTrait;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Meritoo\CommonBundle\Traits\Test\Entity\EntityTestCaseTrait
 */
class EntityTestCaseTraitTest extends TestCase
{
    public function testPersistAndFlush(): void
    {
        $trait = $this->getMockedTrait('persistAndFlush');

        $trait
            ->method('persistAndFlush')
            ->willReturn(null)
        ;

        static::assertNull($trait->persistAndFlush(new \stdClass()));
    }

    public function testUpdateDatabaseSchema(): void
    {
        $trait = $this->getMockedTrait('updateDatabaseSchema');

        $trait
            ->method('updateDatabaseSchema')
            ->willReturn(null)
        ;

        static::assertNull($trait->updateDatabaseSchema());
    }

    public function testDropDatabaseSchema(): void
    {
        $trait = $this->getMockedTrait('dropDatabaseSchema');

        $trait
            ->method('dropDatabaseSchema')
            ->willReturn(null)
        ;

        static::assertNull($trait->dropDatabaseSchema());
    }

    public function testGetEntityManager(): void
    {
        $trait = $this->getMockedTrait('getEntityManager');
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $trait
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
            ->method('getRepository')
            ->willReturn($repository)
        ;

        static::assertInstanceOf(ObjectRepository::class, $trait->getRepository(\stdClass::class));
    }

    private function getMockedTrait(string $method): MockObject
    {
        return $this->getMockForTrait(EntityTestCaseTrait::class, [], '', true, true, true, [$method]);
    }
}
