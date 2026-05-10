<?php

    namespace App\Entity;

    use App\Repository\UserRepository;
    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Security\Core\User\UserInterface;
    use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


    #[ORM\Entity(repositoryClass: UserRepository::class)]
    #[ORM\Table(name: 'users')]
    class User implements UserInterface, PasswordAuthenticatedUserInterface
    {
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[ORM\Column(type: 'string', length: 255)]
        private ?string $name = null;

        #[ORM\Column(type: 'string', length: 75, unique: true)]
        private ?string $email = null;

        #[ORM\Column(type: 'string', length: 255)]
        private ?string $password = null;

        #[ORM\Column(type: 'string', length: 11, nullable: true)]
        private ?string $cpf = null;

        #[ORM\Column(type: 'boolean', options: ['default' => false])]
        private bool $admin = false;

        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?\DateTimeInterface $created_at = null;

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getName(): ?string
        {
            return $this->name;
        }

        public function setName(string $name): self
        {
            $this->name = $name;

            return $this;
        }

        public function getEmail(): ?string
        {
            return $this->email;
        }

        public function setEmail(string $email): self
        {
            $this->email = $email;

            return $this;
        }

        public function getCpf(): ?string
        {
            return $this->cpf;
        }

        public function setCpf(?string $cpf): self
        {
            $this->cpf = $cpf;

            return $this;
        }

        public function isAdmin(): bool
        {
            return $this->admin;
        }

        public function setAdmin(bool $admin): self
        {
            $this->admin = $admin;

            return $this;
        }

        public function getCreatedAt(): ?\DateTimeInterface
        {
            return $this->created_at;
        }

        public function setCreatedAt(?\DateTimeInterface $created_at): self
        {
            $this->created_at = $created_at;

            return $this;
        }

        public function getRoles(): array
        {
            $roles = ['ROLE_USER'];

            if ($this->admin)
            {
                $roles[] = 'ROLE_ADMIN';
            }

            return array_unique($roles);
        }

        public function eraseCredentials(): void
        {
        }

        public function getUserIdentifier(): string
        {
            return $this->email;
        }

        public function getPassword(): ?string
        {
            return $this->password;
        }

        public function setPassword(string $password): self
        {
            $this->password = $password;

            return $this;
        }
    }
