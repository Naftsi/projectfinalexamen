<?php

namespace App\Form;
use App\Entity\Agence;
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

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
            ->add('marque',TextType::class)
            ->add('couleur',TextType::class)
            ->add('nbrPlace',IntegerType::class,array('attr'=> array('min' => 0)))
            ->add('description',TextareaType::class)
            ->add('matricule',TextType::class)
            ->add('carburant',TextType::class)
            ->add('disponibilite',TextType::class)
            ->add('datemiseencirculation',DateTimeType::class)
            ->add('client',EntityType::class,[
                'class'=>Client::class,
                'choice_label'=>'id',
                'label'=>'client'])
            ->add('agence',EntityType::class , [
                'class' => Agence::class ,
                'choice_label' => 'id' ,
                'label' => 'Agence'
               
            ])
            ->add('ajouter',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
