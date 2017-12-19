<?php

namespace Time\TBSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TbsPosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->remove('hourlyRate')
            ->remove('active')
            ->remove('tbs_service')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Time\TBSBundle\Entity\TbsPoste'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'time_tbsbundle_tbsposte';
    }
}
