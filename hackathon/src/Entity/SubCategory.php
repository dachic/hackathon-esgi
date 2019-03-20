<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\SubCategoryRepository")
 */
class SubCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_fr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_en;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="Subcategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }


    /**
     * Get the value of libelle_fr
    */ 
    public function getLibelle_fr()
    {
        return $this->libelle_fr;
    }

    /**
     * Set the value of libelle_fr
     *
     * @return  self
     */ 
    public function setLibelle_fr($libelle_fr)
    {
        $this->libelle_fr = $libelle_fr;

        return $this;
    }

    /**
     * Get the value of libelle_en
     */ 
    public function getLibelle_en()
    {
        return $this->libelle_en;
    }

    /**
     * Set the value of libelle_en
     *
     * @return  self
     */ 
    public function setLibelle_en($libelle_en)
    {
        $this->libelle_en = $libelle_en;

        return $this;
    }
}
