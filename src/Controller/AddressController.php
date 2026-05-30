<?php

    namespace App\Controller;

    use App\Repository\AddressRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;
    use Symfony\Component\Routing\Annotation\Route;


    /**
     *
     */
    class AddressController extends AbstractController
    {
        /**
         *
         */
        public function __construct(private AddressRepository $addressRepository)
        {
        }

        /**
         *
         */
        public function index(SessionInterface $session): Response
        {
            $user = $session->get('user');

            if (!$user) {
                return $this->redirectToRoute('login');
            }

            $address = $this->addressRepository
                ->getByUserId($user['id']);

            $adminTheme = $_ENV['APP_THEME_SYSTEM'];

            return $this->render(
                'system/' . $adminTheme . '/dashboard/address.html.twig',
                [
                    'title' => 'Meu Endereço',
                    'user' => $user,
                    'page' => 'dashboard.address',
                    'admin_theme' => $adminTheme,
                    'address' => $address
                ]
            );
        }

        /**
         *
         */
        public function save(Request $request, SessionInterface $session): Response
        {
            $user = $session->get('user');

            if (!$user)
            {
                return $this->redirectToRoute('login');
            }

            $cep = preg_replace(
                '/\D/',
                '',
                $request->request->get('cep', '')
            );

            $errors = [];

            if (strlen(trim($request->request->get('address'))) < 3)
            {
                $errors['address'] = 'Informe o endereço.';
            }

            if (strlen(trim($request->request->get('neighborhood'))) < 3)
            {
                $errors['neighborhood'] = 'Informe o bairro.';
            }

            if (strlen(trim($request->request->get('city'))) < 2)
            {
                $errors['city'] = 'Informe a cidade.';
            }

            $state = strtoupper(
                trim($request->request->get('state'))
            );

            if (strlen($state) !== 2)
            {
                $errors['state'] = 'Use apenas a sigla do estado (ex: SP).';
            }

            if (!preg_match('/^[0-9]{8}$/', $cep))
            {
                $errors['cep'] = 'CEP inválido (use apenas números).';
            }

            if (!empty($errors))
            {
                $adminTheme = $_ENV['APP_THEME_SYSTEM'];

                return $this->render(
                    'system/' . $adminTheme . '/dashboard/address.html.twig',
                    [
                        'title' => 'Meu Endereço',
                        'user' => $user,
                        'page' => 'dashboard.address',
                        'admin_theme' => $adminTheme,
                        'errors' => $errors,
                        'address' => $request->request->all()
                    ]
                );
            }

            $this->addressRepository->saveOrUpdate(
                $user['id'],
                [
                    'address' => $request->request->get('address'),
                    'neighborhood' => $request->request->get('neighborhood'),
                    'city' => $request->request->get('city'),
                    'state' => $state,
                    'cep' => $cep,
                ]
            );

            $this->addFlash(
                'success',
                'Endereço salvo com sucesso!'
            );

            return $this->redirectToRoute(
                'address'
            );
        }
    }
