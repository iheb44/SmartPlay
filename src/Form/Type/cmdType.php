<?php


namespace App\Form\Type;


use App\Entity\Client;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
            ->add('MntCde', TextType::class
                ,array('attr' => array('class' => 'form-control'))
            )
            ->add('save', SubmitType::class, array(
                    'label' => 'Créer',
                'attr' => array('class' => 'btn btn-primary'))

            )
            
        ;
    }
}