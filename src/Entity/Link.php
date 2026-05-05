<?php

    namespace App\Entity;

    use App\Repository\LinkRepository;
    use Doctrine\ORM\Mapping as ORM;

    #[ORM\Entity(repositoryClass: LinkRepository::class)]
    #[ORM\Table(name: 'links')]
    class Link
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $name = null;

        #[ORM\Column(length: 255, nullable: true)]
        private ?string $url = null;

        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $open_in_new_window = false;

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(?string $name): self
        {
            $this->name = $name;
            return $this;
        }

        public function getUrl(): ?string
        {
            return $this->url;
        }

        public function setUrl(?string $url): self
        {
            $this->url = $url;
            return $this;
        }

        public function isOpenInNewWindow(): bool
        {
            return $this->open_in_new_window;
        }

        public function setOpenInNewWindow(bool $value): self
        {
            $this->open_in_new_window = $value;
            return $this;
        }
    }
