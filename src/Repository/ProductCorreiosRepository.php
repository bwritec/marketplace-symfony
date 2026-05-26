<?php

    namespace App\Repository;

    use App\Entity\ProductCorreios;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class ProductCorreiosRepository
        extends ServiceEntityRepository
    {
        public function __construct(
            ManagerRegistry $registry
        ) {
            parent::__construct(
                $registry,
                ProductCorreios::class
            );
        }

        /**
         * Busca dados de frete do produto
         */
        public function findByProductId(
            int $productId
        ): ?ProductCorreios {
            return $this->findOneBy([
                'product_id' => $productId
            ]);
        }
    }
