<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 05.04.17
 * Time: 10:11
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="Chain")
 */
class Chain
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="chains")
     */
    private $user;

    //largest front chainring teeth
    /**
     * @Assert\Range(
     *     min="8",
     *     max="60",
     *     minMessage="your front chainring isn't so small",
     *     maxMessage="your front chainring isn't so large")
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="smallint")
     */
    private $front;
    //largest rear cog teeth
    /**
     * @Assert\Range(
     *     min="5",
     *     max="50",
     *     minMessage="your rear cog isn't so small",
     *     maxMessage="your rear isn't so large")
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="smallint")
     */
    private $rear;
    //chain stay length in inches
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="decimal")
     */
    private $stay;
    //calc result
    /**
     * @ORM\Column(type="decimal")
     */
    private $result;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFront()
    {
        return $this->front;
    }

    /**
     * @param mixed $front
     */
    public function setFront($front)
    {
        $this->front = $front;
    }

    /**
     * @return mixed
     */
    public function getRear()
    {
        return $this->rear;
    }

    /**
     * @param mixed $rear
     */
    public function setRear($rear)
    {
        $this->rear = $rear;
    }

    /**
     * @return mixed
     */
    public function getStay()
    {
        return $this->stay;
    }

    /**
     * @param mixed $stay
     */
    public function setStay($stay)
    {
        $this->stay = $stay;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

//    /**
//     * Chain constructor.
//     * @param $front
//     * @param $rear
//     * @param $stay
//     */
//    public function __construct($front, $rear, $stay)
//    {
//        $this->front = $front;
//        $this->rear = $rear;
//        $this->stay = $stay;
//    }

    public function chainLength()
    {
        $floatLength = 2 * $this->stay + ($this->front/4 + $this->rear/4 + 1);
        $length = round($floatLength, 0, PHP_ROUND_HALF_EVEN);
        $this->result = $length;
        return ['floatLength' => $floatLength,
                'length' => $length];
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Chain
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
