<?php

    namespace App\Repository;

    use App\Entity\Product;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;


    /**
     *
     */
    class ProductRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Product::class);
        }

        public function findLastProductsWithThumbnail(int $limit = 12)
        {
            return $this->createQueryBuilder('p')
                ->leftJoin('p.thumbnails', 't')
                ->addSelect('t')
                ->orderBy('p.id', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }
    }