<?php

namespace Time\TBSBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TbsUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('user','entity', array(
                'class'=>'UserUserBundle:User',
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->groupBy('u.country_working');
                },
                'property'=>'country_working'
            ))
            ->add('weeklyWorkingHours','integer')
            ->remove('period')
            ->add('capacityPercent')
            ->remove('tbs_service')
            ->add('tbs_pole')
            ->add('tbs_poste')
            ->add('pays','country')
            ->add('taux')

        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Time\TBSBundle\Entity\TbsUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'time_tbsbundle_tbsuser';
    }
}
