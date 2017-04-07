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
 * @ORM\Table(name="Wheel")
 */
class Wheel
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="wheels")
     */
    private $user;

    //effective rim diameter, mm
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $ERD;

    //spoke holes, 36, 32 as standard
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $holes;

    //distance between center of the hub to Left flange center, mm
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $centerToLeft;

    //mm
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $centerToRight;

    //mm
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $flangeDiameter;

    //from 0 to 4, integer
    /**
     * @Assert\Type("integer", message="please put numeric value")
     * @ORM\Column(type="integer")
     */
    private $crosses;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultLeft;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultRight;

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
    public function getERD()
    {
        return $this->ERD;
    }

    /**
     * @param mixed $ERD
     */
    public function setERD($ERD)
    {
        $this->ERD = $ERD;
    }

    /**
     * @return float|int
     */
    public function getHoles()
    {
        return $this->holes;
    }

    /**
     * @param float|int $holes
     */
    public function setHoles($holes)
    {
        $this->holes = $holes;
    }

    /**
     * @return mixed
     */
    public function getCenterToLeft()
    {
        return $this->centerToLeft;
    }

    /**
     * @param mixed $centerToLeft
     */
    public function setCenterToLeft($centerToLeft)
    {
        $this->centerToLeft = $centerToLeft;
    }

    /**
     * @return mixed
     */
    public function getCenterToRight()
    {
        return $this->centerToRight;
    }

    /**
     * @param mixed $centerToRight
     */
    public function setCenterToRight($centerToRight)
    {
        $this->centerToRight = $centerToRight;
    }

    /**
     * @return mixed
     */
    public function getFlangeDiameter()
    {
        return $this->flangeDiameter;
    }

    /**
     * @param mixed $flangeDiameter
     */
    public function setFlangeDiameter($flangeDiameter)
    {
        $this->flangeDiameter = $flangeDiameter;
    }

    /**
     * @return mixed
     */
    public function getCrosses()
    {
        return $this->crosses;
    }

    /**
     * @param mixed $crosses
     */
    public function setCrosses($crosses)
    {
        $this->crosses = $crosses;
    }

    /**
     * @return mixed
     */
    public function getResultLeft()
    {
        return $this->resultLeft;
    }

    /**
     * @param mixed $resultLeft
     */
    public function setResultLeft($resultLeft)
    {
        $this->resultLeft = $resultLeft;
    }

    /**
     * @return mixed
     */
    public function getResultRight()
    {
        return $this->resultRight;
    }

    /**
     * @param mixed $resultRight
     */
    public function setResultRight($resultRight)
    {
        $this->resultRight = $resultRight;
    }

//L = sqrt(R^2 + H^2 + F^2 – 2RHcos(720/h*X))-phi/2-t

//L = Length of spoke
//R = Rim radius to spoke ends (ERD/2)
//H = Hub radius to spoke holes
//F = Flange offset from centerline of hub
//X = Cross pattern (2, 3, 4…)
//h = Number of holes in rim
//phi = Diameter of spoke hole in hub
//t = Tension
    public function leftSpoke()
    {
        $halfERD = floor($this->ERD/2);
        $alfa = 2 * M_PI * $this->crosses / $this->holes;
        $floatSpoke = sqrt($this->centerToLeft**2 + $this->flangeDiameter**2 + $halfERD**2 - 2 * $this->centerToLeft * $this->flangeDiameter * cos($alfa));
        $spoke = round($floatSpoke, 0, PHP_ROUND_HALF_EVEN);
        $this->resultLeft = $spoke;
        return $spoke;
    }

    public function rightSpoke()
    {
        $halfERD = floor($this->ERD/2);
        $alfa = 2 * M_PI * $this->crosses / $this->holes;
        $floatSpoke = sqrt($this->centerToRight**2 + $this->flangeDiameter**2 + $halfERD**2 - 2*$this->centerToRight*$this->flangeDiameter * cos($alfa));
        $spoke = round($floatSpoke, 0, PHP_ROUND_HALF_EVEN);
        $this->resultRight = $spoke;
        return $spoke;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     * @return Wheel
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
