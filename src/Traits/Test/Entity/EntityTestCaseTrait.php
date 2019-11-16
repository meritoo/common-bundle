<?php

/**
 * (c) Meritoo.pl, http://www.meritoo.pl
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Meritoo\CommonBundle\Traits\Test\Entity;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

/**
 * Trait for test case related to entity
 *
 * @author    Meritoo <github@meritoo.pl>
 * @copyright Meritoo <http://www.meritoo.pl>
 */
trait EntityTestCaseTrait
{
    /**
     * Persists and flushes given entity
     *
     * @param mixed $entity The entity
     */
    public function persistAndFlush($entity): void
    {
        $entityManager = $this->getEntityManager();

        $entityManager->persist($entity);
        $entityManager->flush();
    }

    /**
     * Updates database schema.
     * Creates all tables based on gathered/existing metadata.
     */
    public function updateDatabaseSchema(): void
    {
        $allMetadata = $this->getAllEntitiesMeta();

        $this
            ->getSchemaTool()
            ->updateSchema($allMetadata)
        ;
    }

    /**
     * Drops database schema.
     * Removes all tables based on gathered/existing metadata.
     */
    public function dropDatabaseSchema(): void
    {
        $allMetadata = $this->getAllEntitiesMeta();

        $this
            ->getSchemaTool()
            ->dropSchema($allMetadata)
        ;
    }

    /**
     * Returns the entity manager
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return static::$kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager()
            ;
    }

    /**
     * Returns repository for given entity
     *
     * @param string $entityClass Fully qualified class name of entity
     * @return ObjectRepository
     */
    public function getRepository(string $entityClass): ObjectRepository
    {
        return $this
            ->getEntityManager()
            ->getRepository($entityClass)
            ;
    }

    private function getAllEntitiesMeta(): array
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->getMetadataFactory()->getAllMetadata();
    }

    private function getSchemaTool(): SchemaTool
    {
        return new SchemaTool($this->getEntityManager());
    }
}
