<?php

    namespace App\Entity;

    use App\Repository\ProductCharacteristicRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(
        repositoryClass: ProductCharacteristicRepository::class
    )]
    #[ORM\Table(name: 'product_characteristics')]
    class ProductCharacteristic
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column]
        private ?int $user_id = null;

        #[ORM\Column]
        private ?int $product_id = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $characteristic = null;

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

        public function getProductId(): ?int
        {
            return $this->product_id;
        }

        public function setProductId(int $product_id): static
        {
            $this->product_id = $product_id;

            return $this;
        }

        public function getCharacteristic(): ?string
        {
            return $this->characteristic;
        }

        public function setCharacteristic(
            ?string $characteristic
        ): static {
            $this->characteristic = $characteristic;

            return $this;
        }
    }
