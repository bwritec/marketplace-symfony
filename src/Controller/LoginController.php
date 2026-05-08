<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Attribute\Route;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


    class LoginController extends AbstractController
    {
        public function index(AuthenticationUtils $authenticationUtils): Response
        {
            /**
             * Se já estiver logado, redireciona.
             */
            if ($this->getUser())
            {
                return $this->redirectToRoute('dashboard');
            }

            return $this->render('system/adminlte-3.2.0/login.html.twig', [
                'title' => 'Login',
                'error' => $authenticationUtils->getLastAuthenticationError(),
                'last_username' => $authenticationUtils->getLastUsername(),
            ]);
        }

        public function auth(): never
        {
            /**
             * O Symfony Security intercepta automaticamente
             * esta rota.
             */
            throw new \LogicException('This method is intercepted by Symfony Security.');
        }

        public function logout(): never
        {
            /**
             * O Symfony Security intercepta automaticamente
             * esta rota.
             */
            throw new \LogicException('Logout is handled by Symfony Security.');
        }
    }
