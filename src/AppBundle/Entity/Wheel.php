<?php
/**
 * Created by PhpStorm.
 * User: mat
 * Date: 05.04.17
 * Time: 10:11
 */

namespace AppBundle;


class Wheel
{
    //effective rim diameter, mm
    private $ERD;
    //spoke holes, 36, 32 as standard
    private $holes;
    //distance between center of the hub to Left flange center, mm
    private $centerToLeft;
    //mm
    private $centerToRight;
    //mm
    private $flangeDiameter;
    //from 0 to 4, integer
    private $crosses;

    private $resultLeft;
    private $resultRight;

    /**
     * Wheel constructor.
     * @param $ERD
     * @param $holes
     * @param $centerToLeft
     * @param $centerToRight
     * @param $flangeDiameter
     * @param $crosses
     */
    public function __construct($ERD, $holes, $centerToLeft, $centerToRight, $flangeDiameter, $crosses)
    {
        $this->ERD = $ERD;
        //formula I use, requires half the number of spokes
        $this->holes = $holes / 2;
        $this->centerToLeft = $centerToLeft;
        $this->centerToRight = $centerToRight;
        $this->flangeDiameter = $flangeDiameter;
        $this->crosses = $crosses;
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
}

$wheel = new Wheel(600, 32, 30, 30, 35, 3);
echo $wheel->leftSpoke() . '<br>';
echo $wheel->rightSpoke();