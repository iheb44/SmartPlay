<?php


namespace App\Form\Type;

use App\Entity\Fournisseur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class jouetType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            ->add('code_four_jouet', EntityType::class, [
                'class' => Fournisseur::class,
                'query_builder' => function (EntityRepository $er) {
                    return(  $er->createQueryBuilder('u')

                        ->orderBy('u.id', 'ASC'));
                },
                'attr' => array('class' => 'custom-select my-1 mr-sm-2'),
                'choice_label' => 'id',
            ])
            ->add('code_jouet', TextType::class,
                array('attr' => array('class' => 'form-control')))
            ->add('des_jouet', TextType::class,
                array('attr' => array('class' => 'form-control')))
            ->add('qte_stock_jouet', TextType::class,
                array('attr' => array('class' => 'form-control')))
            ->add('pu_jouet', TextType::class,
                array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                    'label' => 'Créer',
                'attr' => array('class' => 'btn btn-primary'))
            )
        ;
    }

    // ...
}