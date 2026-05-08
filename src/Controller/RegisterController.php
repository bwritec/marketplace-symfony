<?php

    namespace App\Controller;

    use App\Entity\User;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


    class RegisterController extends AbstractController
    {
        public function index(): Response
        {
            return $this->render('system/' . $_ENV['APP_THEME_SYSTEM'] . '/register.html.twig', [
                'title' => 'Cadastro de Usuário'
            ]);
        }

        public function store(
            Request $request,
            EntityManagerInterface $entityManager,
            UserPasswordHasherInterface $passwordHasher
        ): Response
        {
            $errors = [];

            $name = trim($request->request->get('name'));
            $email = trim($request->request->get('email'));
            $cpf = preg_replace('/[^0-9]/', '', $request->request->get('cpf'));
            $password = $request->request->get('password');

            /**
             * Validações
             */
            if (strlen($name) < 3)
            {
                $errors['name'] = 'O nome deve ter no mínimo 3 caracteres.';
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                $errors['email'] = 'E-mail inválido.';
            }

            if (strlen($cpf) !== 11)
            {
                $errors['cpf'] = 'CPF inválido.';
            }

            if (strlen($password) < 6)
            {
                $errors['password'] = 'A senha deve ter no mínimo 6 caracteres.';
            }

            /**
             * Verifica email duplicado
             */
            $existingEmail = $entityManager
                ->getRepository(User::class)
                ->findOneBy([
                    'email' => $email
                ]);

            if ($existingEmail)
            {
                $errors['email'] = 'Este e-mail já está em uso.';
            }

            /**
             * Verifica CPF duplicado
             */
            $existingCpf = $entityManager
                ->getRepository(User::class)
                ->findOneBy([
                    'cpf' => $cpf
                ]);

            if ($existingCpf)
            {
                $errors['cpf'] = 'Este CPF já está em uso.';
            }

            /**
             * Se houver erros
             */
            if (!empty($errors))
            {
                return $this->render('system/' . $_ENV['APP_THEME_SYSTEM'] . '/register.html.twig', [
                    'title' => 'Cadastro de Usuário',
                    'errors' => $errors
                ]);
            }

            /**
             * Cria usuário
             */
            $user = new User();

            $user->setName($name);
            $user->setEmail($email);
            $user->setCpf($cpf);
            $user->setCreatedAt(new \DateTime());

            /**
             * Hash da senha
             */
            $hashedPassword = $passwordHasher->hashPassword($user, $password);

            $user->setPassword($hashedPassword);

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Usuário cadastrado com sucesso!');

            return $this->redirect('/register');
        }
    }
