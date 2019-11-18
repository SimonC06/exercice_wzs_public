<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\CartProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cart|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cart|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cart[]    findAll()
 * @method Cart[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    /**
     * Fonction perettant de récupérer le cart courant de l'utilisateur.
     * Si le cart n'existe pas, il est alors créé.
     * @param $userId
     * @return Cart
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function getCart($userId){
        /** @var Cart $cart */
        $cart = $this->findOneBy(['user' => $userId]);
        if(!$cart){
            // Instanciation d'un nouveau panier.
            $cart = new Cart();
            $cart->setUser($userId);
            $em = $this->_em;
            $em->persist($cart);
            $em->flush();
        }
        return $cart;
    }
}
