<?php

    namespace App\Entity;

    use App\Repository\ProductCategoryRepository;
    use Doctrine\ORM\Mapping as ORM;


    #[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
    #[ORM\Table(name: 'product_categories')]
    class ProductCategory
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private ?int $id = null;

        #[ORM\Column]
        private ?int $user_id = null;

        #[ORM\Column]
        private ?int $product_id = null;

        #[ORM\Column]
        private ?int $category_id = null;

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

        public function getCategoryId(): ?int
        {
            return $this->category_id;
        }

        public function setCategoryId(int $category_id): static
        {
            $this->category_id = $category_id;

            return $this;
        }
    }
