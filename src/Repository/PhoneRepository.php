<?php

    namespace App\Repository;

    use App\Entity\Phone;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;
    use Doctrine\ORM\EntityManagerInterface;


    class PhoneRepository extends ServiceEntityRepository
    {
        private EntityManagerInterface $entityManager;

        public function __construct(
            ManagerRegistry $registry,
            EntityManagerInterface $entityManager
        ) {
            parent::__construct($registry, Phone::class);

            $this->entityManager = $entityManager;
        }

        /**
         * Busca telefone por usuário
         */
        public function getByUserId(
            int $userId
        ): ?Phone {
            return $this->findOneBy([
                'user_id' => $userId
            ]);
        }

        /**
         * Salva ou atualiza telefone
         */
        public function saveOrUpdate(
            int $userId,
            string $phone
        ): Phone {

            $existing = $this->getByUserId($userId);

            if (!$existing) {
                $existing = new Phone();
                $existing->setUserId($userId);
            }

            $existing->setPhone($phone);

            $this->entityManager->persist($existing);
            $this->entityManager->flush();

            return $existing;
        }
    }
