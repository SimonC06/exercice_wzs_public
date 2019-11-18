<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Utilisateur à qui appartient le panier
     * @var int
     * @ORM\Column(type="integer")
     */
    private $user;

    /**
     * Produit du panier
     * Permet de supprimer tous les produits depuis le panier
     * @ORM\OneToMany(targetEntity="CartProduct", mappedBy="cart", orphanRemoval=true, cascade={"persist", "remove"})
     */
    protected $cartProduct;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param int $user
     */
    public function setUser(int $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getCartProduct()
    {
        return $this->cartProduct;
    }

    /**
     * @param mixed $cartProduct
     */
    public function setCartProduct($cartProduct): void
    {
        $this->cartProduct = $cartProduct;
    }
}
