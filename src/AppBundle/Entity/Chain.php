<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 05.04.17
 * Time: 10:11
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

class Chain
{
    //largest front chainring teeth
    private $front;
    //largest rear cog teeth
    private $rear;
    //chain stay length in inches
    private $stay;
    //calc result
    private $result;

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
}
