<?php

namespace AppBundle\Entity;

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
     * @var string
     *
     * @ORM\Column(name="nom", type="string")
     */
    private $nom;

    /**
     * @var boolean
     *
     * @ORM\Column(name="masculin", type="boolean")
     */
    private $masculin;


    /**
     * @var Date
     *
     * @ORM\Column(name="date_naissance", type="date")
     */
    private $date_naissance;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return Date
     */
    public function getDateNaissance()
    {
        return $this->date_naissance;
    }

    /**
     * @param Date $date_naissance
     */
    public function setDateNaissance($date_naissance)
    {
        $this->date_naissance = $date_naissance;
    }

    /**
     * @return bool
     */
    public function Masculin()
    {
        return $this->masculin;
    }

    /**
     * @param bool $masculin
     */
    public function setmasculin($masculin)
    {
        $this->masculin = $masculin;
    }
}
