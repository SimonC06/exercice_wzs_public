<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CartProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartProduct[]    findAll()
 * @method CartProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartProduct::class);
    }

    /**
     * Fonction d'ajout d'un produit au panier.
     * @param Cart $cart
     * @param Product $product
     * @param int $qty
     * @param int $fromCart
     * @return CartProduct|bool|null
     */
    public function updateCartProduct(Cart $cart, Product $product, int $qty, $fromCart = 0){
        try
        {
            $cartProduct = $this->findOneBy(['cart' => $cart, 'product' => $product]);
            if(!$cartProduct)
                $cartProduct = new CartProduct();
            else
                if(!$fromCart)
                    $qty = $qty + $cartProduct->getQty(); // Incrémentation de la quantité de produit.

            $cartProduct->setProduct($product);
            $cartProduct->setCart($cart);
            $cartProduct->setQty($qty);

            $em = $this->_em;
            $em->persist($cartProduct);
            $em->flush();

            return $cartProduct;
        }
        catch (\Exception $e)
        {
            return false;
        }
    }

    /**
     * Suppression d'un produit du panier
     * @param CartProduct $cartProduct
     * @return bool
     */
    public function deleteCartProduct(CartProduct $cartProduct){
        try{
            $em = $this->_em;
            $em->remove($cartProduct);
            $em->flush();
            return true;
        }catch (\Exception $e){
            return false;
        }
    }
}
