<?php

namespace Time\TBSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TbsPoleType extends AbstractType
{
    private $choices;

    public function __construct($choices)
    {
        $this->choices = $choices;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->remove('active')
            ->remove('tbs_service')
            ->add('manager','entity', array(
                'class' => 'TimeTBSBundle:TbsUser',
                'multiple' => true,
                'attr'=> array('class'=> 'js-example-responsive'),
                //'data'=>$this->choices


               ))

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Time\TBSBundle\Entity\TbsPole'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'time_tbsbundle_tbspole';
    }
}
