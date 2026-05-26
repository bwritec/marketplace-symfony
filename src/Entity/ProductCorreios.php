<?php

    namespace App\Entity;

    use App\Repository\ProductCorreiosRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(
        repositoryClass: ProductCorreiosRepository::class
    )]
    #[ORM\Table(name: 'product_correios')]
    class ProductCorreios
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column]
        private ?int $user_id = null;

        #[ORM\Column]
        private ?int $product_id = null;

        /**
         * Peso
         */
        #[ORM\Column(nullable: true)]
        private ?float $weight = null;

        /**
         * Comprimento
         */
        #[ORM\Column(nullable: true)]
        private ?float $length = null;

        /**
         * Altura
         */
        #[ORM\Column(nullable: true)]
        private ?float $height = null;

        /**
         * Largura
         */
        #[ORM\Column(nullable: true)]
        private ?float $width = null;

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

        public function getWeight(): ?float
        {
            return $this->weight;
        }

        public function setWeight(?float $weight): static
        {
            $this->weight = $weight;

            return $this;
        }

        public function getLength(): ?float
        {
            return $this->length;
        }

        public function setLength(?float $length): static
        {
            $this->length = $length;

            return $this;
        }

        public function getHeight(): ?float
        {
            return $this->height;
        }

        public function setHeight(?float $height): static
        {
            $this->height = $height;

            return $this;
        }

        public function getWidth(): ?float
        {
            return $this->width;
        }

        public function setWidth(?float $width): static
        {
            $this->width = $width;

            return $this;
        }
    }
