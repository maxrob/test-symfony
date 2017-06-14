<?php

namespace ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nutrient
 *
 * @ORM\Table(name="nutrient")
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\NutrientRepository")
 */
class Nutrient
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="measured", type="string", length=255)
     */
    private $measured;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", nullable=true)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="Nutrients")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     */
    private $food;


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
     * Set label
     *
     * @param string $label
     *
     * @return Nutrient
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set measured
     *
     * @param string $measured
     *
     * @return Nutrient
     */
    public function setMeasured($measured)
    {
        $this->measured = $measured;

        return $this;
    }

    /**
     * Get measured
     *
     * @return string
     */
    public function getMeasured()
    {
        return $this->measured;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Nutrient
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @param mixed $food
     */
    public function setFood($food)
    {
        $this->food = $food;
    }
}

