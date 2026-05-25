<?php

    namespace App\Entity;

    use App\Repository\ProductPhotoRepository;
    use Doctrine\ORM\Mapping as ORM;


    #[ORM\Entity(repositoryClass: ProductPhotoRepository::class)]
    #[ORM\Table(name: 'product_photos')]
    class ProductPhoto
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
        private ?string $name = null;

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

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(?string $name): static
        {
            $this->name = $name;

            return $this;
        }
    }
