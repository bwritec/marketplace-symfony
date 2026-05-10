<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use Symfony\Component\Validator\Validation;
    use Symfony\Component\Validator\Constraints as Assert;
    use App\Repository\UserRepository;


    class LoginController extends AbstractController
    {
        public function index(AuthenticationUtils $authenticationUtils, SessionInterface $session): Response
        {
            /**
             * Se já estiver logado, redireciona.
             */
            if ($session->get('user'))
            {
                return $this->redirectToRoute('dashboard');
            }

            return $this->render('system/adminlte-3.2.0/login.html.twig', [
                'title' => 'Login',
                'error' => $authenticationUtils->getLastAuthenticationError(),
                'last_username' => $authenticationUtils->getLastUsername(),
            ]);
        }

        public function auth(Request $request, UserRepository $userRepository, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): Response
        {
            /**
             * Se já estiver logado, redireciona
             */
            if ($session->get('user'))
            {
                return $this->redirectToRoute('dashboard');
            }

            /**
             * Apenas renderiza a página no GET
             */
            if ($request->isMethod('GET'))
            {
                return $this->render('system/adminlte-3.2.0/login.html.twig', [
                    'title' => 'Login'
                ]);
            }

            /**
             * Dados do formulário
             */
            $cpf = trim($request->request->get('cpf'));
            $password = (string) $request->request->get('password');

            /**
             * Validator
             */
            $validator = Validation::createValidator();

            $cpfViolations = $validator->validate($cpf, [
                new Assert\NotBlank(
                    message: 'O CPF é obrigatório.'
                ),

                new Assert\Regex(
                    pattern: '/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                    message: 'CPF inválido.'
                )
            ]);

            $passwordViolations = $validator->validate($password, [
                new Assert\NotBlank(
                    message: 'A senha é obrigatória.'
                ),

                new Assert\Length(
                    min: 6,
                    minMessage: 'A senha deve ter no mínimo {{ limit }} caracteres.'
                )
            ]);

            /**
             * Coleta erros
             */
            $errors = [];

            foreach ($cpfViolations as $violation)
            {
                $errors['cpf'] = $violation->getMessage();
            }

            foreach ($passwordViolations as $violation)
            {
                $errors['password'] = $violation->getMessage();
            }

            /**
             * Se houver erros
             */
            if (!empty($errors))
            {
                return $this->render('system/adminlte-3.2.0/login.html.twig', [
                    'title' => 'Login',
                    'errors' => $errors,
                    'old' => [
                        'cpf' => $request->request->get('cpf')
                    ]
                ]);
            }

            /**
             * Busca usuário pelo CPF
             */
            $user = $userRepository->findOneBy([
                'cpf' => preg_replace('/[^0-9]/', '', $cpf)
            ]);

            /**
             * Verifica senha
             */
            if (!$user || !$passwordHasher->isPasswordValid($user, $password))
            {
                return $this->render('system/adminlte-3.2.0/login.html.twig', [
                    'title' => 'Login',
                    'errors' => [
                        'cpf' => 'CPF ou senha inválidos.'
                    ],

                    'old' => [
                        'cpf' => $request->request->get('cpf')
                    ]
                ]);
            }

            /**
             * Cria sessão
             */
            $session->set('user', [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'cpf' => $user->getCpf(),
                'email' => $user->getEmail(),
                'admin' => $user->isAdmin()
            ]);

            return $this->redirectToRoute('dashboard');
        }

        public function logout(): RedirectResponse
        {
            $this->container->get('security.token_storage')->setToken(null);

            $request = $this->container->get('request_stack')->getCurrentRequest();

            if ($request && $request->hasSession())
            {
                $request->getSession()->invalidate();
            }

            return $this->redirect('/login');
        }
    }
