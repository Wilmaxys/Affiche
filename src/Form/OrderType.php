<?php

namespace App\Form;

use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qte', IntegerType::class, [
                'label' => 'Quantité',
                'row_attr' => ['class' => 'active'],
                'label_attr' => ['class' => 'active'],
                'data' => 1
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Confirmer',
                'attr' => ['class' => 'button'],
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
            'data_class' => Order::class,
        ]);
    }
}
