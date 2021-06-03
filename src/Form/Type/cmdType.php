<?php


namespace App\Form\Type;


use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Jouet;
use App\Entity\LigneCde;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class cmdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ...
            ->add('code_clt_cde', EntityType::class, [
                'class' => Client::class,
                'query_builder' => function (EntityRepository $er) {
                    return(  $er->createQueryBuilder('u')

                        ->orderBy('u.id', 'ASC'));
                },
                'attr' => array('class' => 'custom-select my-1 mr-sm-2'),
                'choice_label' => 'id',


            ])
            ->add('NumCde', TextType::class
                ,array('attr' => array('class' => 'form-control'))
            )
            ->add('RemiseCde', TextType::class
                ,array('attr' => array('class' => 'form-control'))
            )
            /*->add('MntCde', TextType::class
                ,array('attr' => array('class' => 'form-control'))
            )*/


            ->add('ligneCdes', EntityType::class, [
                'label' => 'Jouet',
                'class'       => Jouet::class,
                'placeholder' => 'Sélectionnez Un jouet',
                'mapped'      => false,
                'required'    => true,
                'attr' => array('class' => 'custom-select my-1 mr-sm-2')
            ])
            ->add('QteLigne', TextType::class,[
                'label' => 'qte',
                'mapped'      => false,
                'required'    => true,
                'attr' => array('class' => 'custom-select my-1 mr-sm-2')
            ])
            ->add('remiseLigne', NumberType::class,[
                'label' => 'Remise',
                'mapped'      => false,
                'required'    => true,
                'attr' => array('class' => 'custom-select my-1 mr-sm-2')
            ])
            ->add('save', SubmitType::class, array(
                    'label' => 'Créer',
                'attr' => array('class' => 'btn btn-primary'))

            )
            
        ;
    }
}