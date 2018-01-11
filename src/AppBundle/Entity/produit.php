<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\produitRepository")
 */
class produit
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
     * @ORM\Column(name="code_barre", type="string", length=255, unique=true)
     */
    private $codeBarre;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_consultations", type="integer")
     */
    private $nbConsultations;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_derniere_vue", type="datetime")
     */
    private $dateDerniereVue;


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
     * Set codeBarre
     *
     * @param string $codeBarre
     *
     * @return produit
     */
    public function setCodeBarre($codeBarre)
    {
        $this->codeBarre = $codeBarre;

        return $this;
    }

    /**
     * Get codeBarre
     *
     * @return string
     */
    public function getCodeBarre()
    {
        return $this->codeBarre;
    }

    /**
     * Set nbConsultations
     *
     * @param integer $nbConsultations
     *
     * @return produit
     */
    public function setNbConsultations($nbConsultations)
    {
        $this->nbConsultations = $nbConsultations;

        return $this;
    }

    /**
     * Get nbConsultations
     *
     * @return int
     */
    public function getNbConsultations()
    {
        return $this->nbConsultations;
    }

    /**
     * Set dateDerniereVue
     *
     * @param \DateTime $dateDerniereVue
     *
     * @return produit
     */
    public function setDateDerniereVue($dateDerniereVue)
    {
        $this->dateDerniereVue = $dateDerniereVue;

        return $this;
    }

    /**
     * Get dateDerniereVue
     *
     * @return \DateTime
     */
    public function getDateDerniereVue()
    {
        return $this->dateDerniereVue;
    }



}

