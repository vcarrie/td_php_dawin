<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EvaluationRepository")
 */
class Evaluation
{


    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var int
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;


    /**
     * @ORM\Id
     * @ORM\Column(name="id_produit", type="string", nullable=false)
     * @ORM\ManyToOne(targetEntity="AppBundle/Entity/produit", inversedBy="evaluations")
     * @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     */
    private $id_produit;

    /**
     * @ORM\Id
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\ManyToOne(targetEntity="User", inversedBy="evaluations")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $id_user;



    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Evaluation
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set note
     *
     * @param integer $note
     *
     * @return Evaluation
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return mixed
     */
    public function getIdProduit()
    {
        return $this->id_produit;
    }

    /**
     * @param mixed $id_produit
     */
    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;
    }

    /**
     * @return mixed
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param mixed $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }
}

