<?php

namespace App\Repository;

use App\Entity\Conference;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;

/**
 * @extends ServiceEntityRepository<Conference>
 */
class ConferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conference::class);
    }

    /**
     * @return list<Conference>
     */
    public function searchBetweenDates(DateTimeImmutable|null $start = null, DateTimeImmutable|null $end = null): array
    {
        if (null === $start && null === $end) {
            throw new InvalidArgumentException('At least one date is required to operate this method.');
        }

        $qb = $this->createQueryBuilder('conference');

        if (null !== $start) {
            $qb
                ->andWhere('conference.startAt >= :start')
                ->setParameter('start', $start)
            ;
        }

        if (null !== $end) {
            $qb
                ->andWhere('conference.endAt <= :end')
                ->setParameter('end', $end)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @return list<Conference>
     */
    public function list(): array
    {
        return $this->findAll();
    }

    /**
     * @return list<Conference>
     */
    public function searchByName(string $name): array
    {
        $qb = $this->createQueryBuilder('conference');

        $qb
            ->andWhere($qb->expr()->like('conference.name', ':name'))
            ->setParameter(
                'name',
                "%{$name}%"
            )
        ;

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Conference[] Returns an array of Conference objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Conference
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
