<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;

    #[ORM\Entity]
    #[ORM\Table(name: 'products')]
    class Product
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private int $id;

        #[ORM\Column]
        private string $name;

        #[ORM\Column(type: 'text', nullable: true)]
        private ?string $description = null;

        #[ORM\Column]
        private float $price;

        #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductThumbnail::class)]
        private Collection $thumbnails;

        public function __construct()
        {
            $this->thumbnails = new ArrayCollection();
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function getThumbnails(): Collection
        {
            return $this->thumbnails;
        }
    }
