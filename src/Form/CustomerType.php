<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
// use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $buyConditionsClass = ['class' => 'buy-conditions'];
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('mail', TextType::class)
            ->add('adresse', TextareaType::class)
            ->add('phone', TextType::class, [
                'label' => 'Téléphone'
            ])
            ->add('useConditions', CheckboxType::class, [
                'label' => 'J\'accepte les conditions d\'achat',
                'mapped' => false,
                'attr' => $buyConditionsClass,
                'label_attr' => $buyConditionsClass,
            ])
            ->add('allowDataSave', CheckboxType::class, [
                'label' => 'J\'autorise SFN MAt à stocker mes données et à les utiliser...',
                'mapped' => false,
                'attr' => $buyConditionsClass,
                'label_attr' => $buyConditionsClass,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'button',
                ],
                'row_attr' => ['class' => 'dp-in']
            ])
            ->add('cancel', SubmitType::class, [
                'label' => 'Annuler',
                'attr' => ['class' => 'button'],
                'row_attr' => ['class' => 'dp-in']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
        ]);
    }
}
