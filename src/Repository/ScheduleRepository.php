<?php

namespace App\Repository;

use App\Entity\Schedule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schedule::class);
    }

    /**
     * Find all schedules with optional filtering and pagination
     * 
     * @param array $filters
     * @param int $limit
     * @param int $offset
     * @return Schedule[]
     */
    public function findAllWithFilters(array $filters = [], int $limit = 10, int $offset = 0): array
    {
        $queryBuilder = $this->createQueryBuilder('s');

        if (!empty($filters['name'])) {
            $queryBuilder->andWhere('s.name LIKE :name')
                         ->setParameter('name', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['date'])) {
            $queryBuilder->andWhere('s.date = :date')
                         ->setParameter('date', $filters['date']);
        }

        $queryBuilder->setMaxResults($limit)
                     ->setFirstResult($offset);

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * Find a schedule by ID
     *
     * @param int $id
     * @return Schedule|null
     */
    public function findById(int $id): ?Schedule
    {
        return $this->find($id);
    }

    /**
     * Save a schedule to the database
     *
     * @param Schedule $schedule
     */
    public function save(Schedule $schedule): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($schedule);
        $entityManager->flush();
    }

    /**
     * Delete a schedule from the database
     *
     * @param Schedule $schedule
     */
    public function delete(Schedule $schedule): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->remove($schedule);
        $entityManager->flush();
    }
}
