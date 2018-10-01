<?php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('type');
        $builder->add('category');
        $builder->add('price');
        $builder->add('description');
        $builder->add('user');
        $builder->add('operation_date', DateTimeType::class, [
                      'widget' => 'single_text',
                      'format' => 'yyyy-MM-dd',
                    ]);
        $builder->add('created', DateTimeType::class, [
          'widget' => 'single_text',
          'format' => 'yyyy-MM-dd',
        ]);
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Operation',
            'csrf_protection' => false
        ]);
    }
}