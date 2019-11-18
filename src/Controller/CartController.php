<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 13/11/2019
 * Time: 11:33
 */

namespace App\Controller;

use App\Entity\CartProduct;
use App\Entity\Product;
use App\Repository\CartProductRepository;
use App\Service\CartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/panier", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * Affichage de la page de détail d'un produit
     * @Route("/", name="index")
     * @param CartService $cartService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(CartService $cartService)
    {
        $cart = $cartService->getCart();

        // Récupération des produits du panier
        $cartProductRows = $cart->getCartProduct();

        // Récupération du prix total du panier
        $cartPriceTotal = $cartService->getCartPriceTotal();

        return $this->render('cart/index.html.twig', [
            'cartProductRows' => $cartProductRows,
            'cartPriceTotal' => $cartPriceTotal
        ]);
    }

    /**
     * Supprime un produit du panier
     * @Route("/delete/{product}", name="delete_product")
     * @Method({"POST"})
     * @param CartService $cartService
     * @param Product $product
     * @return JsonResponse
     */
    public function deleteCartProduct(CartService $cartService, Product $product){
        $cart = $cartService->getCart();
        /** @var CartProductRepository $cartProductRepository */
        $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);
        $cartProduct = $cartProductRepository->findOneBy(['cart' => $cart, 'product' => $product]);
        $result = 0;
        if($cartProduct){
            if($cartProductRepository->deleteCartProduct($cartProduct))
                $result = $cartService->getCartPriceTotal();
        }

        return new JsonResponse($result);
    }

    /**
     * Modifie la quantité d'un produit du panier et retourne le prix total du panier
     * @Route("/update/{product}/{qty}", name="update_product")
     * @param CartService $cartService
     * @param Product $product
     * @param int $qty
     * @return JsonResponse
     */
    public function updateQty(CartService $cartService, Product $product, int $qty){
        $cart = $cartService->getCart();
        $result = 0;

        /** @var CartProductRepository $cartProductRepository */
        $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);
        if($cartProductRepository->updateCartProduct($cart, $product, $qty, 1))
            $result = $cartService->getCartPriceTotal();

        return new JsonResponse($result);
    }
}