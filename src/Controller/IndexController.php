<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        //
        // Récupération des produits
        //
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productRows = $productRepository->findAll();

        //
        // Render
        //
        return $this->render('index/index.html.twig', [
            'productRows' => $productRows
        ]);
    }

    /**
     * Page "A propos"
     * @Route("/a-propos", name="about")
     */
    public function about()
    {
        //
        // Render
        //
        return $this->render('index/about.html.twig', []);
    }
}
