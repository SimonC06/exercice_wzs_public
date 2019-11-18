<?php

namespace App\Twig;

use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartExtension extends \Twig\Extension\AbstractExtension
{
    private $_session;
    private $_em;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager)
    {
        $this->_session = $session;
        $this->_em = $entityManager;
    }

    public function getName()
    {
        return 'cart';
    }

    public function getFunctions()
    {
        $functionArray = array();

        //
        // Récupère le nombre de produit présent dans le panier de l'utilisateur.
        //
        array_push($functionArray, new \Twig\TwigFunction('cartProductQty', function () {
            $cartService = new CartService($this->_session, $this->_em);
            $cartProductQty = $cartService->getCartQtyTotal();
            return $cartProductQty;
        }));

        return $functionArray;
    }
}