<?php

namespace App\Form;
use App\Form\ClientType ;
use App\Entity\Client ;
use App\Entity\Facture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType ;
class FactureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date_de_facture', DateTimeType::class)
            ->add('montant',IntegerType::class)
            ->add('payee' , CheckboxType::class, [
                'label'    => 'payee',
                'required' => false,
            ] )
            ->add('client',EntityType::class , [
                'class' =>  Client::class ,
                'choice_label' => 'id' ,
                'label' => 'Client'
               
            ])
            ->add('ajouter' , SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Facture::class,
        ]);
    }
}
