<?php

namespace Wishters\UserBundle\Form\Type;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends BaseType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
                ->add('region', 'entity', array('required'=> true,
                        'attr'  => array('class' => 'form-control input-sm'),
                        'class' => 'WishtersFrontBundle:Region',
                        'property' => 'nom',
                        'empty_value'=>'Determiner votre Region...'));
        $builder->remove('avatar');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'wishters_user_registration';
    }
}
