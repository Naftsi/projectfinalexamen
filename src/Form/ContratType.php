<?php

namespace App\Form;

use App\Entity\Contrat;
use App\Entity\Voiture;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType ;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',TextType::class)
            ->add('date_de_depart',DateTimeType::class)
            ->add('date_de_retour',DateTimeType::class)
            ->add('voiture',EntityType::class , [
                'class' => Voiture::class ,
                'choice_label' => 'id' ,
                'label' => 'Voiture'
               
            ])
            ->add('client',EntityType::class , [
                'class' => Client::class ,
                'choice_label' => 'id' ,
                'label' => 'client'
               
            ])
            ->add('Ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
