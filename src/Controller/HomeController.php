<?php

    namespace App\Controller;

    use App\Repository\ProductRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;


    /**
     * 
     */
    class HomeController extends AbstractController
    {
        /**
         * 
         */
        public function index(ProductRepository $productRepository): Response
        {
            $lastProducts = $productRepository->findLastProductsWithThumbnail(12);

            return $this->render('themes/essentials/index.html.twig', [
                'title' => 'Página inicial',
                'last_products' => $lastProducts,
            ]);
        }

        /**
         * 
         */
        public function blank(): Response
        {
            return $this->render('themes/essentials/blank.html.twig', [
                'title' => 'Branco',
            ]);
        }
    }