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
     * @return mixed
     */
    public function getIdItem()
    {
        return $this->id_item;
    }

    /**
     * @param mixed $id_item
     */
    public function setIdItem($id_item): void
    {
        $this->id_item = $id_item;
    }

    /**
     * * @ORM\OneToMany(targetEntity="App\Entity\item", mappedBy="id_cart", orphanRemoval=true)
     */
    private $id_item;

    public function getId(): ?int
    {
        return $this->id;
    }
}
