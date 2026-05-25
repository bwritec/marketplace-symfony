<?php

    namespace App\Repository;

    use App\Entity\ProductPhoto;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class ProductPhotoRepository extends ServiceEntityRepository
    {
        public function __construct(
            ManagerRegistry $registry
        ) {
            parent::__construct(
                $registry,
                ProductPhoto::class
            );
        }

        /**
         * Busca fotos do produto
         */
        public function findByProductId(
            int $productId
        ): array {
            return $this->findBy([
                'product_id' => $productId
            ]);
        }
    }
