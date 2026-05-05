<?php

    namespace App\Repository;

    use App\Entity\Category;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class CategoryRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Category::class);
        }

        /**
         * Equivalente ao getAll()
         */
        public function getAllWithParent(): array
        {
            return $this->createQueryBuilder('c1')
                ->leftJoin('c1.parent', 'c2')
                ->addSelect('c2')
                ->orderBy('c1.id', 'DESC')
                ->getQuery()
                ->getResult();
        }

        /**
         * Equivalente ao getParents()
         */
        public function getParents(): array
        {
            return $this->createQueryBuilder('c')
                ->where('c.parent IS NULL')
                ->getQuery()
                ->getResult();
        }

        /**
         * Equivalente ao paginate()
         */
        public function getPaginated(int $page = 1, int $limit = 10): array
        {
            return $this->createQueryBuilder('c1')
                ->leftJoin('c1.parent', 'c2')
                ->addSelect('c2')
                ->orderBy('c1.id', 'DESC')
                ->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }
    }