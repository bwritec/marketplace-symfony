<?php

    namespace App\Entity;

    use App\Repository\AddressRepository;
    use Doctrine\ORM\Mapping as ORM;


    #[ORM\Entity(repositoryClass: AddressRepository::class)]
    #[ORM\Table(name: 'addresses')]
    class Address
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column]
        private ?int $user_id = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $address = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $neighborhood = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $city = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $state = null;

        #[ORM\Column(length: 9, nullable: true)]
        private ?string $cep = null;

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

        public function getAddress(): ?string
        {
            return $this->address;
        }

        public function setAddress(?string $address): static
        {
            $this->address = $address;

            return $this;
        }

        public function getNeighborhood(): ?string
        {
            return $this->neighborhood;
        }

        public function setNeighborhood(
            ?string $neighborhood
        ): static {
            $this->neighborhood = $neighborhood;

            return $this;
        }

        public function getCity(): ?string
        {
            return $this->city;
        }

        public function setCity(?string $city): static
        {
            $this->city = $city;

            return $this;
        }

        public function getState(): ?string
        {
            return $this->state;
        }

        public function setState(?string $state): static
        {
            $this->state = $state;

            return $this;
        }

        public function getCep(): ?string
        {
            return $this->cep;
        }

        public function setCep(?string $cep): static
        {
            $this->cep = $cep;

            return $this;
        }
    }
