<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity]
    #[ORM\Table(name: 'product_thumbnails')]
    class ProductThumbnail
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private int $id;

        #[ORM\Column]
        private string $name;

        #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'thumbnails')]
        #[ORM\JoinColumn(nullable: false)]
        private Product $product;

        public function getName(): string
        {
            return $this->name;
        }
    }