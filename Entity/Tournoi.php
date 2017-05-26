<?php

namespace AppBundle\Entity;

/**
 * Tournoi
 */
class Tournoi
{
    /**
     * @var integer
     */
    private $idtable;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $maxuser;

    /**
     * @var \AppBundle\Entity\Format
     */
    private $idformat;

    /**
     * @var \AppBundle\Entity\User
     */
    private $idroot;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $iduser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->iduser = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idformat = new  \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idtable
     *
     * @return integer
     */
    public function getIdtable()
    {
        return $this->idtable;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Tournoi
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Tournoi
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set maxuser
     *
     * @param integer $maxuser
     *
     * @return Tournoi
     */
    public function setMaxuser($maxuser)
    {
        $this->maxuser = $maxuser;

        return $this;
    }

    /**
     * Get maxuser
     *
     * @return integer
     */
    public function getMaxuser()
    {
        return $this->maxuser;
    }

    /**
     * Set idformat
     *
     * @param \AppBundle\Entity\Format $idformat
     *
     * @return Tournoi
     */
    public function setIdformat(\AppBundle\Entity\Format $idformat = null)
    {
        $this->idformat = $idformat;

        return $this;
    }
    public function setformat(\AppBundle\Entity\Format $idformat = null)
    {
        return $this->setIdformat($idformat);
    }

    /**
     * Get idformat
     *
     * @return \AppBundle\Entity\Format
     */
    public function getIdformat()
    {
        return $this->idformat;
    }
    public function getFormat(){
        return $this->getIdformat();
    }

    /**
     * Set idroot
     *
     * @param \AppBundle\Entity\User $idroot
     *
     * @return Tournoi
     */
    public function setIdroot(\AppBundle\Entity\User $idroot = null)
    {
        $this->idroot = $idroot;

        return $this;
    }

    /**
     * Get idroot
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdroot()
    {
        return $this->idroot;
    }

    /**
     * Add iduser
     *
     * @param \AppBundle\Entity\User $iduser
     *
     * @return Tournoi
     */
    public function addIduser(\AppBundle\Entity\User $iduser)
    {
        $this->iduser[] = $iduser;

        return $this;
    }

    /**
     * Remove iduser
     *
     * @param \AppBundle\Entity\User $iduser
     */
    public function removeIduser(\AppBundle\Entity\User $iduser)
    {
        $this->iduser->removeElement($iduser);
    }

    /**
     * Get iduser
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIduser()
    {
        return $this->iduser;
    }
    /**
     * @var string
     */
    private $description;


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Tournoi
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
