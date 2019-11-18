<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductImageRepository")
 */
class ProductImage
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $product;

    /**
     * Nom du fichier
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $file;

    /**
     * Nom de la miniature
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $fileThumb;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFileThumb(): string
    {
        return $this->fileThumb;
    }

    /**
     * @param string $fileThumb
     */
    public function setFileThumb(string $fileThumb): void
    {
        $this->fileThumb = $fileThumb;
    }

}
