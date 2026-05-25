<?php

    namespace App\Entity;

    use App\Repository\PhoneRepository;
    use Doctrine\ORM\Mapping as ORM;


    #[ORM\Entity(repositoryClass: PhoneRepository::class)]
    #[ORM\Table(name: 'phones')]
    class Phone
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column]
        private ?int $user_id = null;

        #[ORM\Column(length: 12, nullable: true)]
        private ?string $phone = null;

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getUserId(): ?int
        {
            return $this->user_id;
        }

        public function setUserId(int $user_id): static
        {
            $this->user_id = $user_id;

            return $this;
        }

        public function getPhone(): ?string
        {
            return $this->phone;
        }

        public function setPhone(?string $phone): static
        {
            $this->phone = $phone;

            return $this;
        }
    }
