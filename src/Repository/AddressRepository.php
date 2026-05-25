<?php

    namespace App\Repository;

    use App\Entity\Address;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;
    use Doctrine\ORM\EntityManagerInterface;


    class AddressRepository extends ServiceEntityRepository
    {
        private EntityManagerInterface $entityManager;

        public function __construct(
            ManagerRegistry $registry,
            EntityManagerInterface $entityManager
        ) {
            parent::__construct($registry, Address::class);

            $this->entityManager = $entityManager;
        }

        /**
         * Busca endereço por usuário
         */
        public function getByUserId(
            int $userId
        ): ?Address {
            return $this->findOneBy([
                'user_id' => $userId
            ]);
        }

        /**
         * Salva ou atualiza endereço
         */
        public function saveOrUpdate(
            int $userId,
            array $data
        ): Address {

            $address = $this->getByUserId($userId);

            if (!$address) {
                $address = new Address();
                $address->setUserId($userId);
            }

            $address->setAddress(
                $data['address'] ?? null
            );

            $address->setNeighborhood(
                $data['neighborhood'] ?? null
            );

            $address->setCity(
                $data['city'] ?? null
            );

            $address->setState(
                $data['state'] ?? null
            );

            $address->setCep(
                $data['cep'] ?? null
            );

            $this->entityManager->persist($address);
            $this->entityManager->flush();

            return $address;
        }
    }
