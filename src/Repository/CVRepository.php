<?php

namespace App\Repository;

use App\Entity\CV;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CV>
 *
 * @method CV|null find($id, $lockMode = null, $lockVersion = null)
 * @method CV|null findOneBy(array $criteria, array $orderBy = null)
 * @method CV[]    findAll()
 * @method CV[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CVRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CV::class);
    }

    public function add(CV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CV $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByKeyword($keyword)
    {
        $em = $this->getEntityManager()->getConnection();
        $sql = 'select * from cv where match(experience) against(?)';
        $statement = $em->prepare($sql);
        $statement->bindValue(1, $keyword);
        $value = $statement->execute();
        return $value->fetchAllAssociative();
    }
}
