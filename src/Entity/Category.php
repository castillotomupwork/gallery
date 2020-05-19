<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * 
 * @CustomAssert\NotHtmlTag
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="category_name", type="string", length=190)
     * 
     * @Assert\NotBlank(
     *      message = "Category Name should not be empty."
     * )
     */
    private $categoryName;

    /**
     * @ORM\Column(name="category_link", type="string", length=190)
     * 
     * @Assert\NotBlank(
     *      message = "Category Link should not be empty."
     * )
     */
    private $categoryLink;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function getCategoryLink(): ?string
    {
        return $this->categoryLink;
    }

    public function setCategoryLink(string $categoryLink): self
    {
        $this->categoryLink = $categoryLink;

        return $this;
    }
}
