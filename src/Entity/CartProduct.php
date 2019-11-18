<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartProductRepository")
 */
class CartProduct
{
    /**
     * Panier
     * @var Cart
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Cart")
     */
    private $cart;

    /**
     * Produit
     * @var Product
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="carts")
     */
    private $product;

    /**
     * Quantité du produit
     * @var int
     * @ORM\Column(type="smallint", options={"default"=0})
     */
    private $qty;

    /**
     * @return Cart
     */
    public function getCart(): Cart
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     */
    public function setCart(Cart $cart): void
    {
        $this->cart = $cart;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return int
     */
    public function getQty(): int
    {
        return $this->qty;
    }

    /**
     * @param int $qty
     */
    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }
}
