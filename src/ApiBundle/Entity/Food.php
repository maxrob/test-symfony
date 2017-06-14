<?php

namespace ApiBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Food
 *
 * @ORM\Table(name="food")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\FoodRepository")
 */
class Food
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="origgpcd", type="string", length=255)
     */
    private $origgpcd;

    /**
     * @var string
     *
     * @ORM\Column(name="origgpfr", type="string", length=255)
     */
    private $origgpfr;

    /**
     * @var string
     *
     * @ORM\Column(name="origfdcd", type="string", length=255)
     */
    private $origfdcd;

    /**
     * @var string
     *
     * @ORM\Column(name="origfdnm", type="string", length=255)
     */
    private $origfdnm;

    /**
     * @ORM\OneToMany(targetEntity="Nutrient", mappedBy="food")
     */
    private $nutrients;

    public function __construct()
    {
        $this->nutrients = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOriggpcd()
    {
        return $this->origgpcd;
    }

    /**
     * @param string $origgpcd
     */
    public function setOriggpcd($origgpcd)
    {
        $this->origgpcd = $origgpcd;
    }

    /**
     * @return string
     */
    public function getOriggpfr()
    {
        return $this->origgpfr;
    }

    /**
     * @param string $origgpfr
     */
    public function setOriggpfr($origgpfr)
    {
        $this->origgpfr = $origgpfr;
    }

    /**
     * @return string
     */
    public function getOrigfdcd()
    {
        return $this->origfdcd;
    }

    /**
     * @param string $origfdcd
     */
    public function setOrigfdcd($origfdcd)
    {
        $this->origfdcd = $origfdcd;
    }

    /**
     * @return mixed
     */
    public function getOrigfdnm()
    {
        return $this->origfdnm;
    }

    /**
     * @param mixed $origfdnm
     */
    public function setOrigfdnm($origfdnm)
    {
        $this->origfdnm = $origfdnm;
    }

    /**
     * Add nutrient
     *
     * @param Nutrient $nutrient
     *
     * @return Food
     */
    public function addNutrient(Nutrient $nutrient)
    {
        $this->nutrients[] = $nutrient;

        return $this;
    }

    /**
     * Remove nutrient
     *
     * @param Nutrient $nutrient
     */
    public function removeNutrient(Nutrient $nutrient)
    {
        $this->nutrients->removeElement($nutrient);
    }

    /**
     * Get nutrients
     *
     * @return ArrayCollection
     */
    public function getNutrients()
    {
        return $this->nutrients;
    }
}
