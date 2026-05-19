<?php

    namespace App\Repository;

    use App\Entity\Favorite;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class FavoriteRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, Favorite::class);
        }

        /**
         * Verifica se produto está favoritado
         */
        public function isFavorited(
            int $userId,
            int $productId
        ): bool
        {
            return $this->findOneBy([
                'user_id' => $userId,
                'product_id' => $productId
            ]) !== null;
        }
    }
