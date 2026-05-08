<?php

    namespace App\Repository;

    use App\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    class UserRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, User::class);
        }

        public function getByCpf(string $cpf): ?User
        {
            /**
             * Remove pontos e traço
             */
            $cpf = preg_replace('/[^0-9]/', '', $cpf);

            return $this->createQueryBuilder('u')
                ->andWhere('u.cpf = :cpf')
                ->setParameter('cpf', $cpf)
                ->getQuery()
                ->getOneOrNullResult();
        }
    }
