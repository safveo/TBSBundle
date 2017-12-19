<?php

namespace Time\TBSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TbsManagersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active')
            ->add('tbs_pole')
            ->add('tbs_User')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Time\TBSBundle\Entity\TbsManagers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'time_tbsbundle_tbsmanagers';
    }
}
