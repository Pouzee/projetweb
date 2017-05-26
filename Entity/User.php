<?php

namespace AppBundle\Entity;


use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * User
 */
class User implements UserInterface
{
    /**
     * @var integer
     */
    private $iduser;

    /**
     * @var string
     */
    private $pseudo;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idtournoi;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idtournoi = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get iduser
     *
     * @return integer
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set pseudo
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getUsername(){
        return $this->getPseudo();
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * Add idtournoi
     *
     * @param \AppBundle\Entity\Tournoi $idtournoi
     *
     * @return User
     */
    public function addIdtournoi(\AppBundle\Entity\Tournoi $idtournoi)
    {
        $this->idtournoi[] = $idtournoi;

        return $this;
    }

    /**
     * Remove idtournoi
     *
     * @param \AppBundle\Entity\Tournoi $idtournoi
     */
    public function removeIdtournoi(\AppBundle\Entity\Tournoi $idtournoi)
    {
        $this->idtournoi->removeElement($idtournoi);
    }

    /**
     * Get idtournoi
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdtournoi()
    {
        return $this->idtournoi;
    }

    public function getSalt()
    {
        // The bcrypt algorithm doesn't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRoles(){
        return array('ROLE_USER');
    }

    public function eraseCredentials(){
        
    }

    public function serialize()
    {
        return serialize(array(
            $this->iduser,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }


    public function unserialize($serialized)
    {
        list (
            $this->iduser,
            $this->pseudo,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }
}
