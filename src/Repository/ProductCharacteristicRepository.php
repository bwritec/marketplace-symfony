<?php

    namespace App\Repository;

    use App\Entity\ProductCharacteristic;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;


    class ProductCharacteristicRepository
        extends ServiceEntityRepository
    {
        public function __construct(
            ManagerRegistry $registry
        ) {
            parent::__construct(
                $registry,
                ProductCharacteristic::class
            );
        }

        /**
         * Busca características do produto
         */
        public function findByProductId(
            int $productId
        ): array {
            return $this->findBy([
                'product_id' => $productId
            ]);
        }
    }
