<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 05.04.17
 * Time: 10:11
 */

namespace AppBundle;


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
     * Chain constructor.
     * @param $front
     * @param $rear
     * @param $stay
     */
    public function __construct($front, $rear, $stay)
    {
        $this->front = $front;
        $this->rear = $rear;
        $this->stay = $stay;
    }

    public function chainLength()
    {
        $floatLength = 2 * $this->stay + ($this->front/4 + $this->rear/4 + 1);
        $length = round($floatLength, 0, PHP_ROUND_HALF_EVEN);
        $this->result = $length;
        return ['floatLength' => $floatLength,
                'length' => $length];
    }
}

$chain = new Chain(44, 22, 16);

var_dump($chain->chainLength());