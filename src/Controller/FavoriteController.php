<?php

    namespace App\Controller;

    use App\Entity\Favorite;
    use App\Repository\FavoriteRepository;
    use App\Repository\ProductRepository;
    use App\Repository\ProductThumbnailRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\RedirectResponse;
    use Symfony\Component\HttpFoundation\Session\SessionInterface;


    class FavoriteController extends AbstractController
    {
        /**
         *
         */
        private FavoriteRepository $favoriteRepository;

        /**
         *
         */
        private ProductRepository $productRepository;

        /**
         *
         */
        private ProductThumbnailRepository $thumbnailRepository;

        /**
         *
         */
        private EntityManagerInterface $entityManager;

        /**
         *
         */
        public function __construct(FavoriteRepository $favoriteRepository, ProductRepository $productRepository, ProductThumbnailRepository $thumbnailRepository, EntityManagerInterface $entityManager)
        {
            $this->favoriteRepository = $favoriteRepository;
            $this->productRepository = $productRepository;
            $this->thumbnailRepository = $thumbnailRepository;
            $this->entityManager = $entityManager;
        }

        /**
         * Adiciona aos favoritos
         */
        public function add(Request $request, SessionInterface $session): Response
        {
            $user = $this->getUser();

            if (!$user)
            {
                return $this->redirectToRoute('login');
            }

            $userId = $request->request->get('user_id');
            $productId = $request->request->get('product_id');

            /**
             * Evita duplicados
             */
            $exists = $this->favoriteRepository->findOneBy([
                'user' => $userId,
                'product' => $productId
            ]);

            if ($exists)
            {
                $this->addFlash('warning', 'Produto já está favoritado.');

                return $this->redirect($request->headers->get('referer'));
            }

            $favorite = new Favorite();

            $favorite->setUser(
                $this->entityManager
                    ->getReference(\App\Entity\User::class, $userId)
            );

            $favorite->setProduct(
                $this->entityManager
                    ->getReference(\App\Entity\Product::class, $productId)
            );

            $this->entityManager->persist($favorite);
            $this->entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        /**
         * Remove dos favoritos
         */
        public function remove(Request $request, SessionInterface $session): Response
        {
            $user = $this->getUser();

            if (!$user)
            {
                return $this->redirectToRoute('login');
            }

            $userId = $request->request->get('user_id');
            $productId = $request->request->get('product_id');

            $favorite = $this->favoriteRepository->findOneBy([
                'user' => $userId,
                'product' => $productId
            ]);

            if (!$favorite) {
                throw $this->createNotFoundException(
                    'Favorito não encontrado.'
                );
            }

            $this->entityManager->remove($favorite);
            $this->entityManager->flush();

            return $this->redirect($request->headers->get('referer'));
        }

        /**
         * Lista favoritos do usuário
         */
        public function list(SessionInterface $session): Response
        {
            $user = $session->get('user');

            if (!$user)
            {
                return $this->redirectToRoute('login');
            }

            $favorites = $this->favoriteRepository->findBy([
                'user_id' => $user['id']
            ]);

            $products = [];

            foreach ($favorites as $fav)
            {
                $product = $fav->getProduct();

                if ($product)
                {
                    $thumbnail = $this->thumbnailRepository->findOneBy([
                        'product' => $product->getId()
                    ]);

                    /**
                     * Calcula taxa
                     */
                    $taxa = (float) ($_ENV['APP_RATE'] ?? 0);
                    $price = (float) str_replace(
                        ',',
                        '.',
                        $product->getPrice()
                    );

                    $priceFinal = $price + (
                        $price * ($taxa / 100)
                    );

                    $products[] = [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'price' => $priceFinal,
                        'thumbnail' => $thumbnail
                            ? $thumbnail->getName()
                            : null,
                    ];
                }
            }

            $adminTheme = $_ENV['APP_THEME_SYSTEM'];

            return $this->render(
                'system/' . $adminTheme . '/dashboard/favorites.html.twig',
                [
                    'title' => 'Favoritos',
                    'page' => 'dashboard.favorites',
                    'user' => $user,
                    'admin_theme' => $adminTheme,
                    'favorites' => $products
                ]
            );
        }
    }
