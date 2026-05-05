<?php

    namespace App\Entity;

    use App\Repository\CategoryRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(repositoryClass: CategoryRepository::class)]
    #[ORM\Table(name: 'categories')]
    class Category
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[ORM\ManyToOne(targetEntity: self::class)]
        #[ORM\JoinColumn(name: 'parent', referencedColumnName: 'id', nullable: true, onDelete: 'SET NULL')]
        private ?Category $parent = null;

        #[ORM\Column(length: 30, nullable: true)]
        private ?string $name = null;

        #[ORM\Column(length: 30, nullable: true)]
        private ?string $slogan = null;

        #[ORM\Column(type: 'text', nullable: true)]
        private ?string $description = null;

        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?\DateTimeInterface $created_at = null;

        // getters e setters

        public function getId(): ?int { return $this->id; }

        public function getParent(): ?Category { return $this->parent; }
        public function setParent(?Category $parent): self { $this->parent = $parent; return $this; }

        public function getName(): ?string { return $this->name; }
        public function setName(?string $name): self { $this->name = $name; return $this; }

        public function getSlogan(): ?string { return $this->slogan; }
        public function setSlogan(?string $slogan): self { $this->slogan = $slogan; return $this; }

        public function getDescription(): ?string { return $this->description; }
        public function setDescription(?string $description): self { $this->description = $description; return $this; }

        public function getCreatedAt(): ?\DateTimeInterface { return $this->created_at; }
        public function setCreatedAt(?\DateTimeInterface $created_at): self { $this->created_at = $created_at; return $this; }
    }
