<?php

    namespace App\Repository;

    use App\Entity\PasswordReset;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;


    class PasswordResetRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, PasswordReset::class);
        }

        public function createToken(string $email, string $token): PasswordReset
        {
            /**
             * Remove tokens antigos
             */
            $oldTokens = $this->findBy([
                'email' => $email
            ]);

            $entityManager = $this->getEntityManager();

            foreach ($oldTokens as $oldToken)
            {
                $entityManager->remove($oldToken);
            }

            $reset = new PasswordReset();

            $reset->setEmail($email);
            $reset->setToken($token);
            $reset->setCreatedAt(new \DateTime());

            return $reset;
        }

        public function getByToken(string $token): ?PasswordReset
        {
            return $this->findOneBy([
                'token' => $token
            ]);
        }

        public function deleteToken(string $token): void
        {
            $reset = $this->findOneBy([
                'token' => $token
            ]);

            if ($reset)
            {
                $this->getEntityManager()->remove($reset);
                $this->getEntityManager()->flush();
            }
        }
    }
