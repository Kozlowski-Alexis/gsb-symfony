<?php

namespace App\Form;
use App\Entity\FraisForfait;
use App\Entity\LigneFraisForfait;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneFraisForfaitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fraisForfait', EntityType::class, [
                'class' => FraisForfait::class,
                'attr' => ['class' => 'form-control'],
                'label' => 'Type de frais forfait'
            ])
            ->add('date', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
                'label' => 'Date'
            ])
            ->add('quantite', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Quantité'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-outline-info btn-block'],
                'label' => 'Valider'
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LigneFraisForfait::class,
        ]);
    }
}