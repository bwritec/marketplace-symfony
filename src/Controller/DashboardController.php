<?php

    namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;

    class DashboardController extends AbstractController
    {
        public function index(SessionInterface $session): Response
        {
            $user = $session->get('user');

            if (!$user)
            {
                return $this->redirectToRoute('login');
            }

            $adminTheme = $_ENV['APP_THEME_SYSTEM'];

            return $this->render(
                'system/' . $adminTheme . '/dashboard/index.html.twig',
                [
                    'title' => 'Dashboard',
                    'page' => 'dashboard.index',
                    'admin_theme' => $adminTheme,
                    'user' => $user,
                ]
            );
        }
    }
