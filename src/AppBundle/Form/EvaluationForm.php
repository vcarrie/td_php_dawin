<?php
/**
 * Created by PhpStorm.
 * User: valentin
 * Date: 10/01/18
 * Time: 18:35
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class EvaluationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id_produit', HiddenType::class);
        $builder->add('note', ChoiceType::class, array(
            'choices'  => array(
                '0' => 0,
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            )));
        $builder->add('commentaire', TextareaType::class);
    }


}