<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 13/11/2019
 * Time: 11:33
 */

namespace App\Controller;


use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use App\Repository\CartProductRepository;
use App\Repository\CartRepository;
use App\Repository\ProductRepository;
use App\Service\CartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @Route("/produit", name="product_")
 */
class ProductController extends AbstractController
{
    /**
     * Action d'ajout d'un produit au panier
     * @Route("/add-product")
     * @Method({"POST"})
     * @param Request $request
     * @param CartService $cartService
     * @return JsonResponse
     */
    public function add(Request $request, CartService $cartService)
    {
        /** @var ProductRepository $productRepository */
        $productRepository = $this->getDoctrine()->getRepository(Product::class);

        $productId = $request->get('productId');
        $productQty = $request->get('productQty');
        $product = $productRepository->findOneBy(['id' => $productId]);
        $result = 0;

        if($product){
            $cart = $cartService->getCart();

            /** @var CartProductRepository $cartProductRepository */
            $cartProductRepository = $this->getDoctrine()->getRepository(CartProduct::class);

            if($cartProduct = $cartProductRepository->updateCartProduct($cart,$product, $productQty)){
                $cartTotalQty = $cartService->getCartQtyTotal();
                $result = $cartTotalQty;
            }
        }
        return new JsonResponse($result);
    }

    /**
     * Affichage de la page de détail d'un produit
     * @Route("/{url}", name="detail")
     * @param $url
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detail($url){
        /** @var ProductRepository $productRepository */
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        $productRow = $productRepository->findBy(['url' => $url])[0]; // On admettra bien volontier que la clé [0] retournera toujours un résultat.

        return $this->render('product/one.html.twig', [
            'productRow' => $productRow
        ]);
    }

}