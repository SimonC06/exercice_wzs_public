<?php
/**
 * Created by PhpStorm.
 * User: Simon
 * Date: 15/11/2019
 * Time: 10:23
 */

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $_session = null;
    private $_em = null;
    private $_cart = null;

    /**
     * CartService constructor.
     * @param SessionInterface $session
     * @param EntityManagerInterface $entityManager
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->_session = $session;
        $this->_em = $entityManager;

        /** @var CartRepository $cartRepository */
        $cartRepository = $this->_em->getRepository(Cart::class);
        $this->_cart = $cartRepository->getCart($session->get('user'));
    }

    /**
     * Retourne le panier de l'utilisateur
     * @return Cart|null
     */
    public function getCart(){
        return $this->_cart;
    }

    /**
     * Retourne la quantité total de produit du panier en cours
     * @return int
     */
    public function getCartQtyTotal()
    {
        $cartProductRows = $this->getCart()->getCartProduct();
        $total = 0;
        if($cartProductRows){
            /** @var CartProduct $cartProductRow */
            foreach($cartProductRows as $cartProductRow){
                $total += $cartProductRow->getQty();
            }
        }
        return $total;
    }

    /**
     * Retourne le prix total du panier en cours
     * @return int
     */
    public function getCartPriceTotal(){
        $cartProductRows = $this->getCart()->getCartProduct();
        $total = 0;
        if($cartProductRows){
            /** @var CartProduct $cartProductRow */
            foreach($cartProductRows as $cartProductRow){
                $productPrice = $cartProductRow->getProduct()->getPrice();
                $cartProductQty = $cartProductRow->getQty();
                $total += $productPrice * $cartProductQty;
            }
        }
        return floatval($total);
    }
}