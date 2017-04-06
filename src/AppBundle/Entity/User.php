<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="smallint")
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Wheel", mappedBy="id")     *
     */
    private $wheels;

    /**
     * @ORM\Column(type="smallint")
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Chain", mappedBy="id")
     */
    private $chains;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->wheels = new ArrayCollection();
        $this->chains = new ArrayCollection();
    }

    /**
     * Add wheels
     *
     * @param \AppBundle\Entity\Wheel $wheels
     * @return User
     */
    public function addWheel(\AppBundle\Entity\Wheel $wheels)
    {
        $this->wheels[] = $wheels;

        return $this;
    }

    /**
     * Remove wheels
     *
     * @param \AppBundle\Entity\Wheel $wheels
     */
    public function removeWheel(\AppBundle\Entity\Wheel $wheels)
    {
        $this->wheels->removeElement($wheels);
    }

    /**
     * Get wheels
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWheels()
    {
        return $this->wheels;
    }

    /**
     * Add chains
     *
     * @param \AppBundle\Entity\Chain $chains
     * @return User
     */
    public function addChain(\AppBundle\Entity\Chain $chains)
    {
        $this->chains[] = $chains;

        return $this;
    }

    /**
     * Remove chains
     *
     * @param \AppBundle\Entity\Chain $chains
     */
    public function removeChain(\AppBundle\Entity\Chain $chains)
    {
        $this->chains->removeElement($chains);
    }

    /**
     * Get chains
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChains()
    {
        return $this->chains;
    }

    /**
     * Set wheels
     *
     * @param integer $wheels
     * @return User
     */
    public function setWheels($wheels)
    {
        $this->wheels = $wheels;

        return $this;
    }

    /**
     * Set chains
     *
     * @param integer $chains
     * @return User
     */
    public function setChains($chains)
    {
        $this->chains = $chains;

        return $this;
    }
}
