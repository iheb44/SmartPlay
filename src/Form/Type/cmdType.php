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
                'choice_label' => 'id',
            ])
            ->add('NumCde', TextType::class)
            /*->add('DateCde', DateType::class, [
                'widget' => 'choice',

            ])*/
            ->add('DateCde', 'date', array(
            'format' => \IntlDateFormatter::SHORT,
            'input' => 'datetime',
            'widget' => 'single_text',
            'data' => new \DateTime("now")))
            ->add('HeureCde', TimeType::class, [
                'input'  => 'datetime',
                'widget' => 'choice',
            ])
            ->add('RemiseCde', TextType::class)
            ->add('MntCde', TextType::class)
            ->add('save', SubmitType::class, array(
                    'label' => 'Créer')
            )
            
        ;
    }
}